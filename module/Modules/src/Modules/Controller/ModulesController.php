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
		$module = $this->getEntityManager()->getRepository('Modules\Entity\Test');
		
		$test = new \Modules\Entity\Test();
		$builder = new AnnotationBuilder();
		$form = $builder->createForm($test);

		if ($this->request->isPost()) {
			$form->bind($test);
	        $form->setData($this->request->getPost());
	        if ($form->isValid()) {
	            //die('valid');
	        	$this->getEntityManager()->persist($test);
	        	$this->getEntityManager()->flush();
	        	// redirect
	        } else {
	        	//die('invalid');
	        }

	    }
		
		return new ViewModel(array(
				'form' => $form
		));
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
				'data' => $module->findAll()
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
		$module = $this->getEntityManager()->getRepository('Modules\Entity\Test');
		
		$builder = new AnnotationBuilder();
		$form = $builder->createForm(new \Modules\Entity\Test());
		
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