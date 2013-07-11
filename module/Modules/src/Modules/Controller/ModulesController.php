<?php
// module/Modules/src/Modules/Controller/ModulesController.php:
namespace Modules\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;

//use Zend\Form\Annotation\AnnotationBuilder;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

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
		$module = $this->getEntityManager()->getRepository('Modules\Entity\Tables\\'.$name);

		$form = $this->getServiceLocator()->get('formMapperService')->setupEntityForm('Modules\Entity\Tables\\'.$name);

		$listed = array();

		// Get listed fields
		foreach($form->getElements() as $element){
			if($element->getOption('listed')){
				$listed[] = $element;
			}
		}

		// Set pagination
		$adapter = new DoctrineAdapter(new ORMPaginator($module->findModuleItems()));
		$paginator = new Paginator($adapter);
		$paginator->setDefaultItemCountPerPage(10);

		$page = (int)$this->params()->fromQuery('page');
		if($page){
			$paginator->setCurrentPageNumber($page);
		} else {
			$page = 1;
		}

		return new ViewModel(array(
				'listed' => $listed,
				'name' => $name,
				'paginator' => $paginator,
				'form' => $form,
				'page' => $page,
				'flashMessages' => $this->flashMessenger()->getMessages()
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
		$module = $this->getEntityManager()->getRepository('Modules\Entity\Tables\\'.$name);

		$form = $this->getServiceLocator()->get('formMapperService')->setupEntityForm('Modules\Entity\Tables\\'.$name);

		// Get entity
		$entity = $module->find($id);

		$form->bind($entity);

		// Process post request
		if ($this->request->isPost()) {

			// process files first
			$post = $this->getServiceLocator()->get('fileProcessingService')->processFiles($this->request);

			$form->setData($post);
			if ($form->isValid()) {

				// map data to entity
				$entity = $this->getServiceLocator()->get('formMapperService')->mapFormDataToEntity($form, $entity);

				// persist entity
				$this->getEntityManager()->persist($entity);
				$this->getEntityManager()->flush();

				// redirect
				$this->flashMessenger()->addMessage('Changes saved!');
				return $this->redirect()->toRoute('modules/show', array('name' => $name));
			} else {
				//die('invalid');
			}

		}

		return new ViewModel(array(
				'form' => $form,
				'name' => $name,
				'id' => $id
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
		$formParent = $this->getServiceLocator()->get('formMapperService')->setupEntityForm('Modules\Entity\Tables\\'.$parentEntityName);

		// Get entity repository
		$module = $this->getEntityManager()->getRepository($formParent->getOption('sheets')[$sheetName]->getOption('targetEntity'));

		$entityClassname = $formParent->getOption('sheets')[$sheetName]->getOption('targetEntity');
		$form = $this->getServiceLocator()->get('formMapperService')->setupEntityForm($entityClassname);

		// Process post request
		if ($this->request->isPost()) {

			// process files first
			$post = $this->getServiceLocator()->get('fileProcessingService')->processFiles($this->request);

			$form->setData($post);
			if ($form->isValid()) {

				// map data to entity
				$entity = $this->getServiceLocator()->get('formMapperService')->mapFormDataToEntity($form, $entity);

				// sheet spicific parameters
				$entity->parent_entity = 'Modules\Entity\\'.$parentEntityName;
				$entity->parent_row_id = $id;

				$this->getEntityManager()->persist($entity);
				$this->getEntityManager()->flush();

				// redirect
				$this->flashMessenger()->addMessage('Entity saved!');
				return $this->redirect()->toRoute('modules/edit/sheet', array('name' => $parentEntityName, 'id' => $id,'sheet_name' => $sheetName));
			} else {
				//die('invalid');
			}

		}

		$data = $module->findBy(array('parent_entity' => 'Modules\Entity\Tables\\'.$parentEntityName, 'parent_row_id' => $id));

		return new ViewModel(array(
				'formParent' => $formParent,
				'form' => $form,
				'data' => $data,
				'entity' => $entityClassname,
				'sheetName' => $sheetName,
				'id' => $id,
				'parentEntityName' => $parentEntityName,
				'flashMessages' => $this->flashMessenger()->getMessages()
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
		$entityClassname = '\Modules\Entity\Tables\\'.$name;

		// Get entity repository
		$module = $this->getEntityManager()->getRepository('Modules\Entity\Tables\\'.$name);

		// Setup entity form
		$form = $this->getServiceLocator()->get('formMapperService')->setupEntityForm('Modules\Entity\Tables\\'.$name);

		if ($this->request->isPost()) {

			// process files first
			$post = $this->getServiceLocator()->get('fileProcessingService')->processFiles($this->request);

			$form->setData($post);
			if ($form->isValid()) {

				// map data to entity
				$entity = $this->getServiceLocator()->get('formMapperService')->mapFormDataToEntity($form, new $entityClassname());

				// persist entity
				$this->getEntityManager()->persist($entity);
				$this->getEntityManager()->flush();

				// redirect
				$this->flashMessenger()->addMessage('Entity saved!');
				return $this->redirect()->toRoute('modules/show', array('name' => $name));
			} else {
				//die('invalid');
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