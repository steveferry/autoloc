<?php
namespace Application\Model;

 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 class Vehicule implements InputFilterAwareInterface
 {
	 protected $inputFilter;  
     public $id;
     public $brand;
     public $model;
	 public $type;
	 public $isRented;
	 public $trunkCapacity;
	 public $vehicleHeight;
	 public $trunkHeight;
	 public $trunkWidth;
	 public $trunkDepth;
	 public $vehicleWidth;

     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->brand = (!empty($data['brand'])) ? $data['brand'] : null;
         $this->model  = (!empty($data['model'])) ? $data['model'] : null;
		 $this->type  = (!empty($data['type'])) ? $data['type'] : null;
		 $this->isRented  = (!empty($data['isRented'])) ? $data['isRented'] : null;
		 $this->trunkCapacity  = (!empty($data['trunkCapacity'])) ? $data['trunkCapacity'] : null;
		 $this->vehicleHeight  = (!empty($data['vehicleHeight'])) ? $data['vehicleHeight'] : null;
		 $this->trunkHeight  = (!empty($data['trunkHeight'])) ? $data['trunkHeight'] : null;
		 $this->trunkWidth  = (!empty($data['trunkWidth'])) ? $data['trunkWidth'] : null;
		 $this->trunkDepth  = (!empty($data['trunkDepth'])) ? $data['trunkDepth'] : null;
		 $this->vehicleWidth  = (!empty($data['vehicleWidth'])) ? $data['vehicleWidth'] : null;
     }
	 public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	 
	 public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'brand',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'model',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));
			 
			 $inputFilter->add(array(
                 'name'     => 'type',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));
             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }
?>