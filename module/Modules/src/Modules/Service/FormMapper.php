<?php
namespace Modules\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Zend\Form\Annotation\AnnotationBuilder;

class FormMapper implements ServiceLocatorAwareInterface
{

	protected $serviceLocator;
	
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;

	public function __construct()
	{
		// construct
	}

	/**
	 * Setup form for entity
	 */
	public function setupEntityForm($entityName) {
		
		$entityClassname = $entityName;
		
		// Get entity instance
		$entity = new $entityClassname();
		
		// Build basic form
		$builder = new AnnotationBuilder();
		
		$builder->setFormFactory($this->getServiceLocator()->get('baseForm'));
		$form = $builder->createForm($entity);
		
		return $form;
		
	}

	/**
	 * Interface methods
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}

	public function getServiceLocator() {
		return $this->serviceLocator;
	}
	
	public function setEntityManager(EntityManager $em)
	{
		$this->em = $em;
	}
	public function getEntityManager()
	{
		if (null === $this->em) {
			$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}
		return $this->em;
	}

}