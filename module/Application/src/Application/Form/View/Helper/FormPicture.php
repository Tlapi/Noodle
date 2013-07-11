<?php
namespace Application\Form\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\ElementInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FormPicture extends AbstractHelper implements ServiceLocatorAwareInterface {

	private $serviceLocator;

	public function render(ElementInterface $element) {

		if($element->getValue()){
			$fileBank = $this->getServiceLocator()->get('FileBank');

			/*
			$thumbnailer = $this->getServiceLocator()->getServiceLocator()->get('WebinoImageThumb');
			$thumb = $thumbnailer->create($fileBank->getFileById($element->getValue())->getAbsolutePath(), $options = array());
			$thumb->resize(100, 100);

			$thumb->save('public/_data/resized.jpg');
			*/
			return '<div class="form_picture">
						<img src="'.$fileBank->getFileById($element->getValue())->getUrl().'" alt="" />
						<a href="#" class="remove">Remove picture</a>
						<input type="hidden" name="picture" value="'.$element->getValue().'" />
					</div>';
		} else {
			return '<input type="file" name="picture" />';
		}

	}

	public function __invoke(ElementInterface $element = null) {
		return $this->render($element);
	}

	/**
	 * Set the service locator.
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return CustomHelper
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
		return $this;
	}
	/**
	 * Get the service locator.
	 *
	 * @return \Zend\ServiceManager\ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}

}