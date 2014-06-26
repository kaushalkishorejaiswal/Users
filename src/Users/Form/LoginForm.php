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
class LoginForm extends Form
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
            'name' => 'userName',
            'attributes' => array(
                'id' => 'userName',
                'type' => 'text',
                'class' => 'input-txt'
            ),
            'options' => array(
                'label' => 'Email'
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'id' => 'password',
                'type' => 'password',
                'class' => 'input-txt'
            ),
            'options' => array(
                'label' => 'Password'
            )
        ));
        
        $this->add(array(
            'name' => 'rememberMe',
            'attributes' => array(
                'id' => 'rememberMe',
                'value' => 1,
                'type' => 'Checkbox'
            ),
            'options' => array(
                'label' => 'Remember me on this computer'
            )
        ));
        
        $this->add(array(
            'name' => 'changePassword',
            'attributes' => array(
                'id' => 'changePassword',
                'value' => 1,
                'type' => 'Checkbox'
            ),
            'options' => array(
                'label' => 'Change Password after login'
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Sign in',
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
