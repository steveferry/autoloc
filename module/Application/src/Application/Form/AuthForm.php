<?php

// module/Album/src/Album/Form/AuthForm.php:
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AuthForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('auth');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
				'class'  => 'form-control',
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
				'class'  => 'form-control',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Authenticate',
                'id' => 'submitbutton',
				'class'  => 'btn btn-default',
            ),
        ));
        
        //$this->inputFilter();
    }
    
    /*private function inputFilter() {
        $inputFilter = new InputFilter();
        $factory = new InputFactory();

        $inputFilter->add($factory->createInput(array(
                    'name' => 'username',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 1,
                                'max' => 100,
                            ),
                        ),
                    ),
                )));

        $inputFilter->add($factory->createInput(array(
                    'name' => 'password',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min' => 6,
                                'max' => 100,
                            ),
                        ),
                    ),
                )));
        
        $this->setInputFilter($inputFilter);
    }*/
}