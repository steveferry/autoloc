<?php
namespace Application\Controller\Plugin;

use \Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Authentification extends AbstractPlugin {
    
    public function redirectNotConnected($controller='auth') {
        $auth = new \Zend\Authentication\AuthenticationService();
        if(!$auth->hasIdentity()) {
            $this->getController()->redirect()->toRoute('home');
        }
    }
	
	public function isAdmin($controller='auth') {
        $auth = new \Zend\Authentication\AuthenticationService();
		$identity = $auth->getIdentity();
        if($identity->username == "toto") 
		{
			$identity->isAdmin = true;
        }
		else
		{
			//$this->getController()->redirect()->toRoute('home');
		}
    }	
	
	public function getUserId()
	{
		$auth = new \Zend\Authentication\AuthenticationService();
		if($auth->hasIdentity())
		{
			$identity = $auth->getIdentity();
			return $identity->id;
		}
		else return 0;
	}
}

?>
