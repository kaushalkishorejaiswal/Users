<?php
/**
 *
 * @author tarunsinghal
 * @desc To Set/Get Permission
 */
namespace Users\Model;

use Zend\Db\Sql\Sql;
use Complysight\ComplysightModel;

class PermissionTable extends ComplysightModel
{

    public $table = 'permission';

    protected $adapter;

    public function __construct($dbAdapter)
    {
        $this->adapter = $dbAdapter;
        parent::__construct($this->adapter);
    }

    /**
     * Get Resource Permission on the respective role
     * 
     * @author Tarun
     * @param <int> $roleId            
     * @throws \Exception
     * @return array
     */
    public function getResourcePermissions($roleId)
    {
        try {
            $sql = new Sql($this->adapter);
            $select = $sql->select()->from(array(
                'p' => $this->table
            ));
            $select->columns(array(
                'resid'
            ));
            
            $select->join(array(
                "r" => "resource"
            ), "p.resid = r.resid", array(
                "name",
                "route"
            ));
            $select->where(array(
                'p.rid' => $roleId
            ));
            $select->order(array(
                'menu_order'
            ));
            
            $statement = $sql->prepareStatementForSqlObject($select);
            $resources = $this->resultSetPrototype->initialize($statement->execute())
                ->toArray();
            return $resources;
        } catch (\Exception $err) {
            throw $err;
        }
    }
}
