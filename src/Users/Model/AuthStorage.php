<?php
/**
 * this class will be used to store the authenticated session
 * @author avadheshmishra
 *
 */
namespace Users\Model;

use Zend\Authentication\Storage;

class AuthStorage extends Storage\Session
{

    public function setRememberMe($rememberMe = 0, $time = 31536000)
    {
        if ($rememberMe == 1) {
            $this->session->getManager()->rememberMe($time);
        }
    }

    public function forgetMe()
    {
        $this->session->getManager()->forgetMe();
    }
}
