<?php

/**
 * LoginForm class
 * @author Display Name <osscube(Kaushal Kishore)>
 * Class to create login form
 */
namespace Users\Form;

use Zend\Form\Form;

/**
 * Roster Form
 *
 * @category Login
 * @package Form
 *         
 * @author Display Name <osscube(Kaushal Kishore)>
 */
class ChangePasswordForm extends Form
{

    /**
     * default constructor
     *
     * @param string $name
     *            name of the form
     */
    public function __construct($name)
    {
        
        // Set form name
        parent::__construct($name);
        
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'old_password',
            'attributes' => array(
                'id' => 'password',
                'type' => 'password'
            ),
            'options' => array(
                'label' => 'Old Password'
            )
        ));
        
        $this->add(array(
            'name' => 'new_password',
            'attributes' => array(
                'id' => 'new_password',
                'type' => 'password',
                'maxlength' => '45'
            ),
            'options' => array(
                'label' => 'New Password'
            )
        ));
        
        $this->add(array(
            'name' => 'confirm_password',
            'attributes' => array(
                'id' => 'confirm_password',
                'type' => 'password'
            ),
            'options' => array(
                'label' => 'Confirm Password'
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Change Password',
                'id' => 'submitbutton',
                'class' => 'btn'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'loginCsrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 3600
                )
            )
        ));
    }
}
