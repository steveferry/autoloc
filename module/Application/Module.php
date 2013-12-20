<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Application\Model\Vehicule;
use Application\Model\VehiculeTable;
use Application\Model\Rent;
use Application\Model\RentTable;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

	public function getServiceConfig()
	{
	 return array(
		 'factories' => array(
			 'Application\Model\VehiculeTable' =>  function($sm) {
				 $tableGateway = $sm->get('VehiculeTableGateway');
				 $table = new VehiculeTable($tableGateway);
				 return $table;
			 },
			 'VehiculeTableGateway' => function ($sm) {
				 $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				 $resultSetPrototype = new ResultSet();
				 $resultSetPrototype->setArrayObjectPrototype(new Vehicule());
				 return new TableGateway('vehicle', $dbAdapter, null, $resultSetPrototype);
			 },
			 'Application\Model\RentTable' =>  function($sm) {
				 $tableGateway = $sm->get('RentTableGateway');
				 $table = new RentTable($tableGateway);
				 return $table;
			 },
			 'RentTableGateway' => function ($sm) {
				 $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				 $resultSetPrototype = new ResultSet();
				 $resultSetPrototype->setArrayObjectPrototype(new Rent());
				 return new TableGateway('rents', $dbAdapter, null, $resultSetPrototype);
			 },
			'Application\Model\UserTable' =>  function($sm) {
				$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				$table     = new Model\UserTable($dbAdapter);
				return $table;
			},		
		 ),
	 );
	}
}
