<?php
namespace Admin;
use Zend\Db\TableGateway\TableGateway;

use Zend\Db\ResultSet\ResultSet;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
    	$eventManager			= $e->getApplication()->getEventManager();
    	$moduleRouteListener	= new ModuleRouteListener();
    	$moduleRouteListener->attach($eventManager);
    	
    	$eventManager->attach('dispatch', array($this, 'loadConfig'));
    }

    public function getFormElementConfig(){
    	return array(
    			'factories'	=> array(
    					'formAdminGroup'	=> function($sm){
    						$myForm	= new \Admin\Form\Group();
    						$myForm->setInputFilter(new \Admin\Form\GroupFilter());
    						return $myForm;
    					},
    			),
    	);
    }
    
    public function getConfig()
    {
        return array_merge(
    			require_once __DIR__ . '/config/module.config.php',
    			require_once __DIR__ . '/config/router.config.php'
    	);
    }

    public function getAutoloaderConfig()
    {
        return array(
        		'Zend\Loader\ClassMapAutoloader'	=> array(
        				__DIR__ . '/autoload_classmap.php'
        		),
	            'Zend\Loader\StandardAutoloader' => array(
	                'namespaces' => array(
	                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
	                ),
	            ),
        );
    }

	public function loadConfig(MvcEvent $e){
		$routeMatch			= $e->getRouteMatch();
		$controllerArray	= explode('\\', $routeMatch->getParam('controller'));

		$viewModel		= $e->getApplication()->getMvcEvent()->getViewModel();
		$viewModel->arrParams = array(
			'module'		=> strtolower($controllerArray[0]),
			'controller'	=> strtolower($controllerArray[2]),
			'action'		=> $routeMatch->getParam('action'),
		);
		
		
		// Set layout
		
		
		
		$config		= $e->getApplication()->getServiceManager()->get('config');
		$controller	= $e->getTarget();
		$controller->layout($config['module_layouts'][$controllerArray[0]]);
	}
	
	public function getServiceConfig(){
		return array(
				'factories'	=> array(
						'GroupTableGateway'	=> function ($sm) {
							$adapter			= $sm->get('dbConfig');
							$resultSetPrototype	= new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\Group());
							return new TableGateway('group', $adapter, null, $resultSetPrototype);
						},
						'Admin\Model\GroupTable'	=> function ($sm) {
							$tableGateway	= $sm->get('GroupTableGateway');
							return new \Admin\Model\GroupTable($tableGateway);
						}
				),
		);
	}

	public function getViewHelperConfig(){
		return array(
				'invokables'	=> array(
						'cmsLinkSort'		=> '\Zendvn\View\Helper\CmsLinkSort',
						'cmsButtonStatus'	=> '\Zendvn\View\Helper\CmsButtonStatus',
						'zvnFormHidden'		=> '\Zendvn\Form\View\Helper\FormHidden',
						'zvnFormSelect'		=> '\Zendvn\Form\View\Helper\FormSelect',
						'zvnFormInput'		=> '\Zendvn\Form\View\Helper\FormInput',
						'zvnFormButton'		=> '\Zendvn\Form\View\Helper\FormButton',
				)
		);
	}

}