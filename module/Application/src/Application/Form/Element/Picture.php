<?php

namespace Application\Form\Element;

use Zend\Form\Element\File;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Picture extends File implements ServiceLocatorAwareInterface
{
	
	protected $serviceLocator;
	
	protected $attributes = array(
			'type' => 'picture',
	);

	public function init()
	{
		// Here, we have $this->serviceLocator !!
	}
	
	public function prepare()
	{
		
	}
	
	public function treatValueBeforeSave()
	{
		
	}
	
	public function getListedValue($row)
	{
		return $row->{$this->getName()}->{$this->getOption('relationColumn')};
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