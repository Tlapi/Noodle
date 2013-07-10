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
		// Get name of entity
		$name = (string) $this->params()->fromRoute('name', 0);

		// Get entity repository
		$module = $this->getEntityManager()->getRepository('Modules\Entity\\'.$name);

		$form = $this->getServiceLocator()->get('formMapperService')->setupEntityForm('Modules\Entity\\'.$name);

		$listed = array();

		foreach($form->getElements() as $element){
			if($element->getOption('listed')){
				$listed[] = $element;
			}
		}

		// Get data
		$data = $module->findBy(array('parent_entity' => null));

		return new ViewModel(array(
				'listed' => $listed,
				'name' => $name,
				'data' => $data,
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

		// Get entity repository
		$module = $this->getEntityManager()->getRepository('Modules\Entity\\'.$name);

		$form = $this->getServiceLocator()->get('formMapperService')->setupEntityForm('Modules\Entity\\'.$name);

		$form->bind($module->find($id));

		return new ViewModel(array(
				'form' => $form
		));
	}

	/**
	 * Edit sheet action
	 * @see Zend\Mvc\Controller.AbstractActionController::indexAction()
	 */
	public function sheetAction()
	{
		$parentEntityName = (string) $this->params()->fromRoute('name', 0);
		$sheetName = (string) $this->params()->fromRoute('sheet_name', 0);
		$id = (string) $this->params()->fromRoute('id', 0);

		// Get parent form
		$formParent = $this->getServiceLocator()->get('formMapperService')->setupEntityForm('Modules\Entity\\'.$parentEntityName);

		// Get entity repository
		$module = $this->getEntityManager()->getRepository($formParent->getOption('sheets')[$sheetName]->getOption('targetEntity'));

		$entityClassname = $formParent->getOption('sheets')[$sheetName]->getOption('targetEntity');
		$form = $this->getServiceLocator()->get('formMapperService')->setupEntityForm($entityClassname);

		// Process post request
		if ($this->request->isPost()) {

			$form->setData($this->request->getPost());
			if ($form->isValid()) {

				$entity = new $entityClassname();
				foreach($form->getElements() as $element){
					$name = $element->getName();
					if(method_exists($element, 'treatValueBeforeSave')){
						$entity->$name = $element->treatValueBeforeSave();
					} else {
						$entity->$name = $element->getValue();
					}
				}

				$entity->parent_entity = 'Modules\Entity\\'.$parentEntityName;
				$entity->parent_row_id = $id;

				$this->getEntityManager()->persist($entity);
				$this->getEntityManager()->flush();
				// redirect
				die('redirect');
			} else {
				die('invalid');
			}

		}

		$data = $module->findBy(array('parent_entity' => 'Modules\Entity\\'.$parentEntityName, 'parent_row_id' => $id));

		return new ViewModel(array(
				'formParent' => $formParent,
				'form' => $form,
				'data' => $data,
				'entity' => $entityClassname
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

		$form = $this->getServiceLocator()->get('formMapperService')->setupEntityForm('Modules\Entity\\'.$name);

		if ($this->request->isPost()) {

			$form->setData($this->request->getPost());
			if ($form->isValid()) {

				$entity = new $entityClassname();
				foreach($form->getElements() as $element){
					$name = $element->getName();
					if(method_exists($element, 'treatValueBeforeSave')){
						$entity->$name = $element->treatValueBeforeSave();
					} else {
						$entity->$name = $element->getValue();
					}
				}

				$this->getEntityManager()->persist($entity);
				$this->getEntityManager()->flush();
				// redirect
				die('redirect');
			} else {
				die('invalid');
			}

		}

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