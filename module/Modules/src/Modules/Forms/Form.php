<?php 
namespace Modules\Forms;

use Zend\Form\Element;

class Form extends \Zend\Form\Factory
{
    protected $captcha;

    public function setCaptcha(CaptchaAdapter $captcha)
    {
        $this->captcha = $captcha;
    }

    public function prepareElements()
    {
        // add() can take either an Element/Fieldset instance,
        // or a specification, from which the appropriate object
        // will be built.

        // We could also define the input filter here, or
        // lazy-create it in the getInputFilter() method.
    }
}