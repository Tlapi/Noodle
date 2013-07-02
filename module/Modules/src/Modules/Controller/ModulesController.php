<?php
// module/Modules/src/Modules/Controller/ModulesController.php:
namespace Modules\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;

use Zend\Form\Annotation\AnnotationBuilder;

class ModulesController extends AbstractActionController
{

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * Void index action
	 * @see Zend\Mvc\Controller.AbstractActionController::indexAction()
	 */
	public function indexAction()
	{
		
	}
	
	/**
	 * Show action
	 * @see Zend\Mvc\Controller.AbstractActionController::indexAction()
	 */
	public function showAction()
	{
		$name = (string) $this->params()->fromRoute('name', 0);
		
		$module = $this->getEntityManager()->getRepository('Modules\Entity\\'.$name);
		$listed = array();
		
		$builder = new AnnotationBuilder();
		$form = $builder->createForm(new \Modules\Entity\Test());
		
		$reader = new \Doctrine\Common\Annotations\AnnotationReader();
		$reflClass = new \ReflectionClass('Modules\Entity\\'.$name);
		foreach ($reflClass->getProperties() as $property) {
			foreach($reader->getPropertyAnnotations($property) as $annotation){
				if($annotation instanceof \Modules\Entity\ListedAnnotation){
					$listed[] = $property->name; 
				}
			}
		}
		//$classAnnotations = $reader->getPropertyAnnotations($reflClass);
		//var_dump($classAnnotations);
		return new ViewModel(array(
				'listed' => $listed,
				'name' => $name,
				'data' => $module->findAll(),
				'form' => $form
		));
		
	}
	/**
	 * Edit action
	 * @see Zend\Mvc\Controller.AbstractActionController::indexAction()
	 */
	public function editAction()
	{
		$name = (string) $this->params()->fromRoute('name', 0);
		$id = (string) $this->params()->fromRoute('id', 0);
		
		$module = $this->getEntityManager()->getRepository('Modules\Entity\\'.$name);
		
		$builder = new AnnotationBuilder();
		$form = $builder->createForm(new \Modules\Entity\Test());
		$form->bind($module->find($id));
		
		return new ViewModel(array(
				'form' => $form
		));
	}
	
	/**
	 * Add action
	 * @see Zend\Mvc\Controller.AbstractActionController::indexAction()
	 */
	public function addAction()
	{
		// Get name of entity
		$name = (string) $this->params()->fromRoute('name', 0);
		$entityClassname = '\Modules\Entity\\'.$name;
				
		// Get entity repository
		$module = $this->getEntityManager()->getRepository('Modules\Entity\\'.$name);
		
		// Get entity instance
		$entity = new $entityClassname();
		
		// Build basic form
		$builder = new AnnotationBuilder();
		
		$formManager = $this->serviceLocator->get('FormElementManager');
		//$form = $formManager->get('Modules\Forms\Form');
		$builder->setFormFactory($this->getServiceLocator()->get('baseForm'));
		$form = $builder->createForm($entity);
		
		//var_dump($form->get('select'));
		
		/*
		// Build special form segments based on form annotation
		$formMapper = $this->getServiceLocator()->get('formMapperService');
		$form = $formMapper->remapFormFields($form, $name);
		
		if ($this->request->isPost()) {
			$form->bind($entity);
			
			$form->setData($this->request->getPost());
			if ($form->isValid()) {
				$entity = $formMapper->bindValues($name, $entity);
			
				$this->getEntityManager()->persist($entity);
				$this->getEntityManager()->flush();
				// redirect
				die('redirect');
			} else {
				//die('invalid');
			}
			
		}*/
		
		return new ViewModel(array(
				'form' => $form
		));
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