<?php
// module/Filesystem/Module.php
namespace Filesystem;

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
    					'fileUploadHandlerService' => function ($serviceManager) {
                			$service = new \Filesystem\Service\UploadHandler($serviceManager->get('FileBank'));
                			return $service;
            			},
    			),
    			'invokables' => array(

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