<?php

/**
 * LoginValidation class
*
* @author Display Name <osscube(Kaushal Kishore)>
* Used to add validator on login form
*/
namespace Users\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\Identical;

/**
 * LoginValidation is used to add validator on login form
 *
 * @category Login
 * @package Model
 *         
 * @author Display Name <osscube(Kaushal Kishore)>
 */
class ChangePasswordValidation implements InputFilterAwareInterface
{

    /**
     *
     * @var object Zend\InputFilter\InputFilterAwareInterface
     */
    protected $_inputFilter;

    /**
     * set interface for input filter
     *
     * @param InputFilterInterface $inputFilter
     *            object of InputFilterInterface
     *            
     * @throws \Exception
     * @return void
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used $inputFilter");
    }

    /**
     * Function to add validation on
     * Add filter form
     *
     * @return object Zend\InputFilter\InputFilterAwareInterface
     */
    public function getInputFilter()
    {
        if (! $this->_inputFilter) {
            $inputFilter = new InputFilter();
            
            $factory = new InputFactory();
            $isEmpty = \Zend\Validator\NotEmpty::IS_EMPTY;
            $minLength = \Zend\Validator\StringLength::TOO_SHORT;
            $maxLength = \Zend\Validator\StringLength::TOO_LONG;
            $regexNotMatched = \Zend\Validator\Regex::NOT_MATCH;
            $identicalNotMatched = \Zend\Validator\Identical::NOT_SAME;
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'old_password',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                $isEmpty => 'Old Password can not be empty.'
                            )
                        ),
                        'break_chain_on_failure' => true
                    )
                ),
                
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                )
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'new_password',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                $isEmpty => 'Password can not be empty.'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                    
                    array(
                        'name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{8,45}$/',
                            'messages' => array(
                                $regexNotMatched => 'Password Must Contain at least one special Character.'
                            )
                        ),
                        'break_chain_on_failure' => true
                    ),
                    
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 8,
                            'max' => 45,
                            'messages' => array(
                                $minLength => 'Password must be more than 8 character',
                                $maxLength => 'Password must be less than 45 character'
                            )
                        ),
                        'break_chain_on_failure' => true
                    )
                ),
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                )
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'confirm_password',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'identical',
                        'options' => array(
                            'token' => 'new_password',
                            'messages' => array(
                                $identicalNotMatched => 'New password and confirm password does not match.'
                            )
                        )
                    ),
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                $isEmpty => 'Confirm Password can not be empty.'
                            )
                        ),
                        'break_chain_on_failure' => true
                    )
                ),
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                )
            )));
            
            $this->_inputFilter = $inputFilter;
        }
        
        return $this->_inputFilter;
    }
}
