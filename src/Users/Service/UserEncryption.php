<?php

/**
 * UserPassword class
 * Manages User Password Configurations
 *
 * @category Complysight
 * @package Service
 *
 * @author "<osscube(Kaushal Kishore)>"
 */
namespace Users\Service;

use Zend\Crypt\Password\Bcrypt;

/**
 * UserPassword class
 * Manages User Password Configurations
 *
 * @category Complysight
 * @package Service
 *         
 * @author "<osscube(Kaushal Kishore)>"
 */
class UserEncryption
{

    protected $serviceManager;

    public $salt = 'aUJGgadjasdgdj';

    public $method = 'sha1';

    private $_encryptionMethod = "AES-256-CBC";

    private $_secretHash = "25c6c7jn35b9979bc51f2136cd14r0ff";

    private $_viCode = "hjdikngd@kn!Dfgh";

    public $_forgotPasswordExpireTime = 604800;

    /**
     * Constructor
     *
     * @author Kaushal Kishore
     * @access public
     *        
     * @param string $method
     *            // Encryption method
     * @return void
     */
    public function __construct($method = null, $serviceManager = null)
    {
        $this->serviceManager = $serviceManager;
        if (! is_null($method)) {
            $this->method = $method;
        }
    }

    /**
     * Create Password
     *
     * @author Kaushal Kishore
     * @access public
     *        
     * @param string $password
     *            User Password
     * @return string
     */
    public function create($password)
    {
        if ($this->method == 'md5') {
            return md5($this->salt . $password);
        } elseif ($this->method == 'sha1') {
            return sha1($this->salt . $password);
        } elseif ($this->method == 'bcrypt') {
            $bcrypt = new Bcrypt();
            $bcrypt->setCost(14);
            return $bcrypt->create($password);
        }
    }

    /**
     * Validate the user password
     *
     * @author Kaushal Kishore
     * @access public
     *        
     * @param string $password
     *            // Password string
     *            
     * @param string $hash
     *            // Hash string
     *            
     * @return boolean
     */
    public function verify($password, $hash)
    {
        if ($this->method == 'md5') {
            return $hash == md5($this->salt . $password);
        } elseif ($this->method == 'sha1') {
            return $hash == sha1($this->salt . $password);
        } elseif ($this->method == 'bcrypt') {
            $bcrypt = new Bcrypt();
            $bcrypt->setCost(14);
            return $bcrypt->verify($password, $hash);
        }
    }

    /**
     *
     * @author Kaushal Kishore
     * @param string $string            
     * @return string
     */
    public function encryptUrlParameter($string = "")
    {
        $encryptedString = openssl_encrypt($string, $this->_encryptionMethod, $this->_secretHash, false, $this->_viCode);
        $encryptedString = base64_encode($encryptedString);
        return $encryptedString;
    }

    /**
     *
     * @author Kaushal Kishore
     * @param string $string            
     * @return string
     */
    public function decryptUrlParameter($string = "")
    {
        $decryptedString = base64_decode($string);
        $decryptedString = openssl_decrypt($decryptedString, $this->_encryptionMethod, $this->_secretHash, false, $this->_viCode);
        return $decryptedString;
    }
}
