<?php
// module/Modules/src/Modules/Controller/ModulesController.php:
namespace Modules\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;

use Doctrine\ORM\Tools\SchemaTool;

use Zend\Form\Annotation\AnnotationBuilder;

class ModulesManagerController extends AbstractActionController
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
	 * Add module action
	 * @see Zend\Mvc\Controller.AbstractActionController::indexAction()
	 */
	public function addAction()
	{
		$form = $this->getServiceLocator()->get('formMapperService')->setupEntityForm('Modules\Entity\Module');

		$builder = new AnnotationBuilder();
		$schema = new SchemaTool($this->getEntityManager());
		$cmf = $this->getEntityManager()->getMetadataFactory();

		// Get entities
		$entityElement = $form->get('entity');
		if ($handle = opendir('module/Modules/src/Modules/Entity/Tables')) { // TODO this to config
			while (false !== ($entry = readdir($handle))) {
				if($entry!="." && $entry!=".."){
					$className = 'Modules\Entity\Tables\\'.str_replace('.php', '', $entry);
					$entity = new $className;
					$options[str_replace('Modules\Entity\Tables\\', '', get_class($entity))] = $builder->getFormSpecification($entity)['name'];

					$classes[] = $cmf->getMetadataFor(get_class($entity));

				}
			}
			closedir($handle);
		}
		$entityElement->setValueOptions($options);

		//var_dump($schema->getCreateSchemaSql($classes));

		// process form
		if ($this->request->isPost()) {

			$form->setData($this->request->getPost());
			if ($form->isValid()) {

				// map data to entity
				$entity = $this->getServiceLocator()->get('formMapperService')->mapFormDataToEntity($form, new \Modules\Entity\Module());

				// persist entity
				$this->getEntityManager()->persist($entity);
				$this->getEntityManager()->flush();

				// redirect
				$this->flashMessenger()->addMessage('Module created!');
				return $this->redirect()->toRoute('modules-manager');
			} else {
				//die('invalid');
				//var_dump($form->)
			}

		}



		return new ViewModel(array(
				'form' => $form,
		));
	}

	/**
	 * Add module action
	 * @see Zend\Mvc\Controller.AbstractActionController::indexAction()
	 */
	public function addRepositoryAction()
	{
		$config = $this->getServiceLocator()->get('config');
		return new ViewModel(array(
			'fieldTypes' => $config['noodle']['field_types']
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