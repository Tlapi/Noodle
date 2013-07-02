<?php
// module/Modules/Module.php
namespace Modules;

//use DoctrineModule\Persistence\ObjectManagerAwareInterface;

class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'baseForm' => function ($sm) {
    						//$service1 = $sm->get('parentPagesService');
    						//$service2 = $sm->get('categoryService');
    						$form    = new \Modules\Forms\Form;
    						
    						
    						//$form->setService($service1, $service2);
    						return $form;
    					},
    			),
    			'invokables' => array(
    					'formMapperService' => '\Modules\Service\FormMapper'
    			),
    	);
    }
    
    public function getFormElementConfig()
    {
    	return array(
    			'factories' => array(
    					'\Application\Form\Element\Relation' => function($sm) {
    						return 'test';
    					}
    			)
    	);
    }
    
}