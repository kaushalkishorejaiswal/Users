<?php
namespace Users\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Session\Container;
use Zend\Db\Sql\Update;
use Users\Service\UserEncryption;

class UsersTable extends AbstractTableGateway
{

    public $table = 'users';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAY);
        $this->initialize();
    }

    /**
     * Function for validating and changing the Password
     *
     * @param unknown $password            
     * @return boolean
     */
    public function validateChangePassword($password)
    {
        $userPassword = new UserEncryption();
        $session = new Container('User');
        $passMsg = array(
            'passChange' => 0,
            'passSame' => 0,
            'passNotSame' => 0
        );
        try {
            // ////Checking the Old Password is valid or not//////
            $old_password = $userPassword->create($password['old_password']);
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()
                ->from($this->table)
                ->columns(array(
                'password'
            ))
                ->where(array(
                'id' => $session->offsetGet('userId'),
                'password' => $old_password
            ));
            $statement = $sql->prepareStatementForSqlObject($select);
            $data = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            if (count($data)) {
                // ///////Password is Valid now change the Password/////
                $userPasswordData['userId'] = $session->offsetGet('userId');
                $userPasswordData['password'] = $password['new_password'];
                if ($this->changeUserPassword($userPasswordData)) {
                    $passMsg['passChange'] = 1;
                } else {
                    $passMsg['passSame'] = 1;
                }
                return $passMsg;
            } else {
                // ///// Password is not valid ///////////
                $passMsg['passNotSame'] = 1;
                return $passMsg;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }

    /**
     * Function for Verifying the Email ID for Forgot Password
     *
     * @param unknown $emailData            
     * @return boolean
     */
    public function verifyEmailForgotPassword($emailData)
    {
        $sql = new Sql($this->getAdapter());
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()
                ->from($this->table)
                ->columns(array(
                'id'
            ))
                ->where(array(
                'email' => $emailData['userName']
            ));
            $statement = $sql->prepareStatementForSqlObject($select);
            $data = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            if (count($data)) {
                return $data[0]['id'];
            } else {
                return false;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }

    /**
     * Function for changing the User Password
     *
     * @param array $userPasswordData            
     * @return boolean
     */
    public function changeUserPassword($userPasswordData, $resetPassword = false)
    {
        $userPassword = new UserEncryption();
        $sql = new Sql($this->getAdapter());
        try {
            $new_password = $userPassword->create($userPasswordData['password']);
            $update = $sql->update();
            $update->table($this->table);
            
            $data = array(
                'password' => $new_password,
                'login_attempts' => 0,
                'login_attempt_time' => 0
            );
            
            $update->set($data);
            
            $update->where(array(
                'id' => $userPasswordData['userId']
            ));
            $statement = $sql->prepareStatementForSqlObject($update);
            $result = $statement->execute();
            // /////Password reset Successfully ///////////
            if ($result->getAffectedRows()) {
                return true;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
        return false;
    }

    /**
     * Fetch super admins list
     *
     * @access public
     * @author Arvind Singh
     * @param array $where
     *            // Conditions
     * @param array $columns
     *            // Specific column names
     * @param string $orderBy
     *            // Order By conditions
     * @param boolean $paging
     *            // Flag for paging
     * @return array
     */
    public function getUsers($where = array(), $columns = array(), $orderBy = '', $paging = false)
    {
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array(
                'user' => $this->table
            ));
            
            if (count($where) > 0) {
                $select->where($where);
            }
            
            if (count($columns) > 0) {
                $select->columns($columns);
            }
            
            if (! empty($orderBy)) {
                $select->order($orderBy);
            }
            
            if ($paging) {
                
                $dbAdapter = new DbSelect($select, $this->getAdapter());
                $paginator = new Paginator($dbAdapter);
                
                return $paginator;
            } else {
                $statement = $sql->prepareStatementForSqlObject($select);
                
                $clients = $this->resultSetPrototype->initialize($statement->execute())
                    ->toArray();
                
                return $clients;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }

    /**
     * Update super admin details
     *
     * @access public
     * @author Arvind Singh
     * @param array $data
     *            // Data
     * @param array $where
     *            // Conditions
     *            
     * @return integer
     */
    public function updateSuperAdmin($data, $where)
    {
        $sql = new Sql($this->getAdapter());
        
        $update = new Update($this->table);
        $update->set($data);
        $update->where($where);
        
        $statement = $sql->prepareStatementForSqlObject($update);
        $results = $statement->execute();
        $affectedRows = $results->getAffectedRows();
        
        return $affectedRows;
    }

    /**
     * Function for getting and setting the login attempts
     *
     * @param unknown $userName            
     * @return unknown
     */
    public function getLoginAttempts($userName)
    {
        $loginAttempts = 0;
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()
                ->from($this->table)
                ->columns(array(
                'login_attempts',
                'login_attempt_time'
            ))
                ->where(array(
                'email' => $userName
            ));
            $statement = $sql->prepareStatementForSqlObject($select);
            $data = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            if (count($data)) {
                // ////////User Found Increase the Login Attempts/////
                $loginAttempts = $data[0]['login_attempts'];
                $loginAttemptTime = $data[0]['login_attempt_time'];
                // ///// Reset the time if user quit the screen before 30
                // minutes ////
                if ($loginAttemptTime + 1800 < time() && $loginAttempts < 4) {
                    $loginAttempts = 0;
                }
                $update = $sql->update();
                $update->table($this->table);
                $update->set(array(
                    'login_attempts' => $loginAttempts + 1,
                    'login_attempt_time' => time()
                ));
                $update->where(array(
                    'email' => $userName
                ));
                $statement = $sql->prepareStatementForSqlObject($update);
                $result = $statement->execute();
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
        return $loginAttempts;
    }

    /**
     * Reseting the Login Attempts after login
     *
     * @param unknown $email            
     * @param unknown $email            
     * @return boolean
     */
    public function resetLoginAttempts($email)
    {
        try {
            $sql = new Sql($this->getAdapter());
            $update = $sql->update();
            $update->table($this->table);
            $update->set(array(
                'login_attempts' => 0,
                'login_attempt_time' => 0
            ));
            $update->where(array(
                'email' => $email
            ));
            $statement = $sql->prepareStatementForSqlObject($update);
            $result = $statement->execute();
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
        return true;
    }

    /**
     *
     * @author avadhesh mishra
     * @param string $username            
     * @throws \Exception
     * @return array
     */
    public function getUserDetailByUsername($username)
    {
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select()->from(array(
                'sa' => $this->table
            ));
            $select->columns(array(
                'id',
                'email',
                'status',
                'first_name',
                'last_name'
            ));
            $select->where(array(
                'email' => $username
            ));
            $statement = $sql->prepareStatementForSqlObject($select);
            
            $roles = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            
            if (! empty($roles[0]) && is_array($roles[0])) {
                return $roles[0];
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }

    /**
     *
     * @param unknown $email            
     * @return boolean
     */
    public function checkMailExits($email = "")
    {
        try {
            $sql = new Sql($this->getAdapter());
            $select = $sql->select();
            $select->from($this->table);
            $select->where(array(
                'email' => $email
            ));
            $statement = $sql->prepareStatementForSqlObject($select);
            $data = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            if (count($data)) {
                return true;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
        return false;
    }
}
