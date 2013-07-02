<?php

namespace Application\Form\Element;

use Zend\Form\Element\Select;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Relation extends Select implements ServiceLocatorAwareInterface
{
	
	protected $serviceLocator;

	public function init()
	{
		// Here, we have $this->serviceLocator !!
	}
	
	public function getListedValue()
	{
		return 'test';
	}
	
	public function setServiceLocator(ServiceLocatorInterface $sl)
	{
		$this->serviceLocator = $sl;
	}
	
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}
	
}
