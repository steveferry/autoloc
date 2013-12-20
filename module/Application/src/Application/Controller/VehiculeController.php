<?php
namespace Application\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Application\Model\Vehicule;
 use Application\Form\VehiculeForm;
use Application\Controller\Plugin;
 class VehiculeController extends AbstractActionController
 {
	protected $vehiculeTable;
	
     public function indexAction()
     {
		 return new ViewModel(array(
             'vehicules' => $this->getVehiculeTable()->fetchAll(),
         ));
     }

	 public function addAction()
     {
         $form = new VehiculeForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $vehicule = new Vehicule();
             $form->setInputFilter($vehicule->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $vehicule->exchangeArray($form->getData());
                 $this->getVehiculeTable()->saveVehicule($vehicule);
                 return $this->redirect()->toRoute('vehicule');
             }
         }
         return array('form' => $form);
     }

     public function editAction()
     {
		$id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('vehicule', array(
                'action' => 'add'
            ));
        }
        $vehicule = $this->getVehiculeTable()->getVehicule($id);

        $form  = new VehiculeForm();
        $form->bind($vehicule);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($vehicule->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getVehiculeTable()->saveVehicule($form->getData());
                return $this->redirect()->toRoute('vehicule');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
     }
	 
     public function detailAction()
     {
		$id = (int) $this->params()->fromRoute('id', 0);
		if($id != 0){
			 return array(
				 'id'    => $id,
				 'vehicule' => $this->getVehiculeTable()->getVehicule($id)
			 );
		 }
		 
		 return $this->redirect()->toRoute('vehicule');
     }

     public function deleteAction()
     {
		$plugin = $this->Authentification();
		$plugin->redirectNotConnected();
		 $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('vehicule');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getVehiculeTable()->deleteVehicule($id);
             }

             return $this->redirect()->toRoute('vehicule');
         }

         return array(
             'id'    => $id,
             'vehicule' => $this->getVehiculeTable()->getVehicule($id)
         );
     }
	 
	 public function getVehiculeTable()
     {
         if (!$this->vehiculeTable) {
             $sm = $this->getServiceLocator();
             $this->vehiculeTable = $sm->get('Application\Model\VehiculeTable');
         }
         return $this->vehiculeTable;
     }
 }
?>