<?php

namespace Application\Controller;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

class AuthController extends \Zend\Mvc\Controller\AbstractActionController {

    protected $userTable;

    public function indexAction() {

		$message = "";
        $form = new \Application\Form\AuthForm();

        $request = $this->getRequest();
		if ($request->isPost()) {
			$data = $request->getPost();
			$login = new \Application\Model\Login();
			$form->setInputFilter($login->getInputFilter());
			$form->setData($data);
			if ($form->isValid()) {
				$sm = $this->getServiceLocator();
				$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

				$authAdapter = new AuthAdapter($dbAdapter,
								'user',
								'username',
								'password',
								'MD5(?)'
				);

				$authAdapter
						->setIdentity($data['username'])
						->setCredential($data['password']);

				$auth = new \Zend\Authentication\AuthenticationService();
				$result = $auth->authenticate($authAdapter);
				
				switch ($result->getCode()) {

					case \Zend\Authentication\Result::FAILURE_IDENTITY_NOT_FOUND:
						$message = "identity not found";
						break;

					case \Zend\Authentication\Result::FAILURE_CREDENTIAL_INVALID:
						$message = "Bad credential";
						break;

					case \Zend\Authentication\Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(
							null,
							'password'
						));
						return $this->redirect()->toRoute('home');
						break;

					default:
						$message = "Unknown error";
						break;
				}
			}
			
			$form->get('password')->setValue("");
		}

		return array(
			'form' => $form,
			'message' => $message,
		);
		return $this->redirect()->toRoute('home');
    }

    public function logoutAction() {
        $auth = new \Zend\Authentication\AuthenticationService();
        $auth->clearIdentity();
		$this->layout()->setVariable('user','');
		//unset($_SESSION['user']);
        return $this->redirect()->toRoute('home');
    }
    
    public function createAction() {
        $form = new \Application\Form\UserForm();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new \Application\Model\User();
            $form->setInputFilter($user->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                
                if(!$this->getUserTable()->nameExists($data["username"])) {
                    $data["password"] = md5($data["password"]);
                    $user->exchangeArray($data);
                    $this->getUserTable()->saveUser($user);

                    return $this->redirect()->toRoute('home');
                }
                
                $form->get('username')->setMessages(array(
                    "This name already exist",
                ));
            }
        }
        
        return array(
            "form" => $form,
        );
    }
    
    /**
     *
     * @return \Album\Model\UserTable
     */
    public function getUserTable()
    {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Application\Model\UserTable');
        }
        return $this->userTable;
    }

}