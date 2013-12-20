<?php
namespace Application\Model;

class login implements \Zend\InputFilter\InputFilterAwareInterface 
{
	protected $inputFilter;
	
	public function exchangeArray($data) {
    }
	
	public function getArrayCopy() {
        return get_object_vars($this);
    }
	
	public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }
	
	public function getInputFilter() {
		if (!$this->inputFilter) 
		{
			$inputFilter = new \Zend\InputFilter\InputFilter();
			$factory = new \Zend\InputFilter\Factory();	
			
			$inputFilter->add($factory->createInput(array(
				'name' => 'username',
				'required' => true
			)));
			
			$inputFilter->add($factory->createInput(array(
				'name' => 'password',
				'required' => true
			)));
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
    }
}
