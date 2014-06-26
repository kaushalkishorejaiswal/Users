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
class ForgotPasswordForm extends Form
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
                'label' => 'Please enter your Email'
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
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
