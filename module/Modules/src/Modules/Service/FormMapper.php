<?php
namespace Modules\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FormMapper implements ServiceLocatorAwareInterface
{

	protected $serviceLocator;

	public function __construct()
	{
		// construct
	}

	/**
	 * Remap form fields according to annotations
	 */
	public function remapFormFields($form, $name) {
		
		$reader = new \Doctrine\Common\Annotations\AnnotationReader();
		$reflClass = new \ReflectionClass('Modules\Entity\\'.$name);
		
		// Cycle through form fields
		foreach ($reflClass->getProperties() as $property) {
			
			$annotations = $reader->getPropertyAnnotations($property);
			$relation = false;
			
			// Cycle through form field annotations
			foreach($annotations as $annotation){
				if($annotation instanceof \Doctrine\ORM\Mapping\OneToOne){
					$relation = true;
					$targetEntity = $annotation->targetEntity;
				}
				if($annotation instanceof \Modules\Entity\RelationAnnotation){
					$targetColumn = $annotation->getPropertyName();
				}
			}
			
			// Form field is relation to another entity
			if($relation){
				$valueOptions = array(0 => 'Select one...');
				$relation = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager')->getRepository($targetEntity);
				foreach($relation->findAll() as $object){
					$valueOptions[$object->id] = $object->$targetColumn;
				}
				$form->get($property->name)->setValueOptions($valueOptions);
			}
			
		}
		
		return $form;
		
	}
	
	public function bindValues($name, $entity) {
		
		$reader = new \Doctrine\Common\Annotations\AnnotationReader();
		$reflClass = new \ReflectionClass('Modules\Entity\\'.$name);
		
		// Cycle through form fields
		foreach ($reflClass->getProperties() as $property) {
				
			$annotations = $reader->getPropertyAnnotations($property);
			$relation = false;
				
			// Cycle through form field annotations
			foreach($annotations as $annotation){
				if($annotation instanceof \Doctrine\ORM\Mapping\OneToOne){
					$relation = true;
					$targetEntity = $annotation->targetEntity;
				}
				if($annotation instanceof \Modules\Entity\RelationAnnotation){
					$targetColumn = $annotation->getPropertyName();
				}
			}
				
			// Form field is relation to another entity
			if($relation){
				$relation = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager')->getRepository($targetEntity);
				$entity->{$property->name} = $relation->find($entity->{$property->name});
			}
				
		}

		return $entity;
		
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

}