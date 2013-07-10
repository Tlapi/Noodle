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

class Module
{

	private $changedLayout;

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'redirectUnauthedUsersEvent'));
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'));

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

    			),
    			'invokables' => array(
    					'modulesService' => '\Application\Service\ModulesService'
    			),
    	);
    }

    public function getViewHelperConfig()
    {
    	return array(
    			'invokables' => array(
    					'formelement'       => 'Application\Form\View\Helper\FormElement',
    					'formPicture'     => 'Application\Form\View\Helper\FormPicture',
    					'moduleList'     => 'Application\View\Helper\ModuleList',
    			),
    	);
    }

    /**
     * Change layout on dispatch
     * @param MvcEvent $e
     */
    public function onDispatch(MvcEvent $e)
    {
    	if($this->changedLayout){
    		$currentController = $e->getTarget();
    		$currentController->layout($this->changedLayout);
    	}
    }

    /**
     * Redirect if the user is not authentificated
     * @param MvcEvent $e
     */
    public function redirectUnauthedUsersEvent(MvcEvent $e)
    {
    	// Check if user is logged in
    	$sm = $e->getApplication()->getServiceManager();

    	// Get our route match
    	$matches = $e->getRouteMatch();
    	$controller = $matches->getParam('controller');
    	$action = $matches->getParam('action');

    	if($controller == 'zfcuser' && $action=='login'){
    		$this->changedLayout = 'layout/layout-login.phtml';
    		return;
    	}

    	$auth = $sm->get('zfcuser_auth_service');
    	if ($auth->hasIdentity()) {
    		return;
    	}

    	// Guest is not allowed to see this path, redirect guest to login page
    	// assemble redirect url
    	$url = $e->getRouter()->assemble(
    			array(),
    			array(
    					'name' => 'zfcuser/login',
    					'force_canonical' => true,
    			)
    	);

    	// redirect
    	/** @var $response \Zend\Http\PhpEnvironment\Response */
    	$response = $e->getResponse();
    	if ($response instanceof \Zend\Http\Response) {
    		$response->getHeaders()->addHeaderLine('Location', $url.'?redirect='.urlencode($_SERVER['REDIRECT_URL']));
    		$response->setStatusCode(307);
    	}

    	return $response;
    }
}
