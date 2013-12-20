<?php


namespace Application\Model;

class User implements \Zend\InputFilter\InputFilterAwareInterface {

    /**
     * @var int 
     */
    public $id;
    
    /**
     * @var string 
     */
    public $completename;
    
    /**
     * @var string 
     */
    public $username;
    
    /**
     * @var string 
     */
    public $password;
    
    /**
     * @var \Zend\InputFilter\InputFilter 
     */
    protected $inputFilter;

    /**
     * Set object attributes with array
     * @param Array $data 
     */
    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->completename = (isset($data['completename'])) ? $data['completename'] : null;
        $this->username = (isset($data['username'])) ? $data['username'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
    }

    /**
     * Copy this object to array
     * @return Array 
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    /**
     * Set the input filter (not used)
     * @param \Zend\InputFilter\InputFilterInterface $inputFilter 
     */
    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    /**
     * Get input filter associate with this object
     * @return \Zend\InputFilter\InputFilter 
     */
    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new \Zend\InputFilter\InputFilter();
            $factory = new \Zend\InputFilter\Factory();

            $inputFilter->add($factory->createInput(array(
                        'name' => 'id',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
                    )));

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

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

?>
