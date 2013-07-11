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
    						$form->setServiceLocator($sm);
    						return $form;
    					},
    			),
    			'invokables' => array(
    					'formMapperService' => '\Modules\Service\FormMapper',
    					'fileProcessingService' => '\Modules\Service\FileProcessing',
    					'repositoriesService' => '\Modules\Service\Repositories',
    			),
    	);
    }

    public function getFormElementConfig()
    {
    	return array(
    			'factories' => array(

    			)
    	);
    }

}