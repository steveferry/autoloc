<?php
namespace Application\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Application\Model\Rent;
 use Application\Form\VehiculeForm;
 
 class RentController extends AbstractActionController
 {
	protected $rentTable;
	
     public function indexAction()
     {
		
		 
		$auth = new \Zend\Authentication\AuthenticationService();
		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
			return new ViewModel(array(
             'rents' => $this->getRentTable()->fetchAllFromUser($identity->id),
         ));
		}
		return new ViewModel(array(
				$this->redirect()->toRoute('vehicule'),
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
	 
	 public function getRentTable()
     {
         if (!$this->rentTable) {
             $sm = $this->getServiceLocator();
             $this->rentTable = $sm->get('Application\Model\RentTable');
         }
         return $this->rentTable;
     }
 }
?>