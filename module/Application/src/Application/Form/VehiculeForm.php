<?php
 namespace Application\Form;

 use Zend\Form\Form;

 class VehiculeForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('vehicule');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'brand',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Marque',
             ),
			 'attributes' => array(
				 'class'  => 'form-control',
             ),
         ));
         $this->add(array(
             'name' => 'model',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Modele',
             ),
			 'attributes' => array(
				 'class'  => 'form-control',
             ),
         ));
		 
		 $this->add(array(
             'name' => 'type',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Type',
             ),
			 'attributes' => array(
				 'class'  => 'form-control',
             ),
         ));
		 
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
				 'class'  => 'btn btn-default',
             ),
         ));
     }
 }
?>