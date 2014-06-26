<?php

/**
 * ClientForm class
 * @author Display Name <osscube(Naveen Kumar)>
 * Class to create client form
 */
namespace Users\Form;

use Zend\Form\Form;

/**
 * Client Form
 *
 * @category ManageClient
 * @package Form
 *         
 * @author Display Name <osscube(Naveen Kumar)>
 */
class MyProfile extends Form
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
            'name' => 'empId',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'emp_id'
            )
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
                'id' => 'email',
                'maxlength' => '50'
            ),
            'options' => array(
                'label' => 'Email'
            )
        ));
        $this->add(array(
            'name' => 'firstName',
            'attributes' => array(
                'type' => 'text',
                'id' => 'firstName',
                'maxlength' => '20'
            ),
            'options' => array(
                'label' => 'First Name'
            )
        ));
        $this->add(array(
            'name' => 'lastName',
            'attributes' => array(
                'type' => 'text',
                'id' => 'lastName',
                'maxlength' => '30'
            ),
            'options' => array(
                'label' => 'Last Name'
            )
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'id' => 'title',
                'maxlength' => '50'
            ),
            'options' => array(
                'label' => 'Title',
                'maxlength' => '20'
            )
        ));
        $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'type' => 'text',
                'id' => 'phone',
                'maxlength' => '12'
            ),
            'options' => array(
                'label' => 'Phone'
            )
        ));
        $this->add(array(
            'name' => 'nameOfCreditUnion',
            'attributes' => array(
                'type' => 'text',
                'id' => 'nameofCreditUnion',
                'maxlength' => '60'
            ),
            'options' => array(
                'label' => 'Name of Credit Union'
            )
        ));
        $this->add(array(
            'name' => 'creditUnionCharter',
            'attributes' => array(
                'type' => 'text',
                'id' => 'creditUnionCharter',
                'maxlength' => '5'
            ),
            'options' => array(
                'label' => 'Credit Union Charter'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'nameOfLeague',
            'options' => array(
                'label' => 'Name of League',
                'value_options' => array(
                    "" => "select league"
                )
            ),
            'attributes' => array(
                'value' => '',
                'style' => 'width:100%'
            )
        ));
        $this->add(array(
            'name' => 'address1',
            'attributes' => array(
                'type' => 'text',
                'id' => 'address1',
                'maxlength' => '70'
            ),
            'options' => array(
                'label' => 'Address1'
            )
        ));
        $this->add(array(
            'name' => 'address2',
            'attributes' => array(
                'type' => 'text',
                'id' => 'address2',
                'maxlength' => '70'
            ),
            'options' => array(
                'label' => 'Address2'
            )
        ));
        $this->add(array(
            'name' => 'state',
            'attributes' => array(
                'type' => 'text',
                'id' => 'state'
            ),
            'options' => array(
                'label' => 'State'
            )
        ));
        
       /* $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'state',
            'options' => array(
                'label' => 'State'
            ),
            'attributes' => array(
                'value' => ''
            )
        ));*/
        
        $this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'state',
        		'options' => array(
        				'label' => 'Associated States'
        		),
        		'attributes' => array(
        				'value' => '',
        				'type'=>'hidden'
        		)
        ));
        
        
        $this->add(array(
            'name' => 'city',
            'attributes' => array(
                'type' => 'text',
                'id' => 'city',
                'maxlength' => '40'
            ),
            'options' => array(
                'label' => 'City'
            )
        ));
        $this->add(array(
            'name' => 'zip',
            'attributes' => array(
                'type' => 'text',
                'id' => 'zip',
                'maxlength' => '5'
            ),
            'options' => array(
                'label' => 'Zip Code'
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'id' => 'submitbutton',
                'value' => 'Update',
                'class' => 'btn'
            )
        ));
    }
}
