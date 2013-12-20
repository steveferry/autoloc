<?php
namespace Application\Model;

 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 class Rent implements InputFilterAwareInterface
 {
	 protected $inputFilter;  
     public $id;
     public $userId;
     public $vehicleId;
	 public $startDate;
	 public $stopDate;
	 public $returned;

     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->userId = (!empty($data['userId'])) ? $data['userId'] : null;
         $this->vehicleId  = (!empty($data['vehicleId'])) ? $data['vehicleId'] : null;
		 $this->startDate  = (!empty($data['startDate'])) ? $data['startDate'] : null;
		 $this->stopDate  = (!empty($data['stopDate'])) ? $data['stopDate'] : null;
		 $this->returned  = (!empty($data['returned'])) ? $data['returned'] : null;
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
                 'name'     => 'userId',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'vehicleId',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));
			 
			 $inputFilter->add(array(
                 'name'     => 'dateStart',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));
			 
			 $inputFilter->add(array(
                 'name'     => 'dateStop',
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