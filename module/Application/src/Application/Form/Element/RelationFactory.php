<?php

namespace Application\Form\Element;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RelationFactory implements FactoryInterface
{
    
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$relationElement = new Relation();

		return $relationElement;
	}
	
}
