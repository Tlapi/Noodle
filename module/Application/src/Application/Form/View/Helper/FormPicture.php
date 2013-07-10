<?php 
namespace Application\Form\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\ElementInterface;

class FormPicture extends AbstractHelper {
	
	public function render(ElementInterface $element) {
		//return $element->getValue();
		
		if($element->getValue())
			return '<img src="" alt="" /> <a href="#">Remove picture</a>';
		else
			return '<input type="file" name="" />';
		
	}
	
	public function __invoke(ElementInterface $element = null) {
		return $this->render($element);
	}
	
}