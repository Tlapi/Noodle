<?php
// module/Filesystem/src/Filesystem/Controller/FilesystemController.php:
namespace Filesystem\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;

//use Zend\Form\Annotation\AnnotationBuilder;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class FilesystemController extends AbstractActionController
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
	 * Upload action
	 * @see Zend\Mvc\Controller.AbstractActionController::indexAction()
	 */
	public function uploadAction()
	{
		/*
		$result = new JsonModel(array(
					'result' => array(
						'files' => array(
							'file' => array(
								'name' => 'testname'
							)
						)
					)
		));
		$result->setTerminal(true);

		return $result;*/
		//error_reporting(E_ALL | E_STRICT);
		//require('UploadHandler.php');
		//$upload_handler = new \Filesystem\Service\UploadHandler();
		$handler = $this->getServiceLocator()->get('fileUploadHandlerService');
		exit();
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