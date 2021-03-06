<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

use Zend\Form\Annotation;

/**
 * A movie
 *
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("Module")
 * @ORM\Entity
 * @ORM\Table(name="modules")
 * @property integer $id
 * @property string $module_name
 */
class Module
{

	/**
	* @ORM\Id
	* @ORM\Column(type="integer");
	* @ORM\GeneratedValue(strategy="AUTO")
	* @Annotation\Exclude()
	*/
	public $id;

	/**
	* @ORM\Column(type="string");
	* @Annotation\Type("Zend\Form\Element\Text")
	* @Annotation\Options({"label":"Module name:", "listed":true})
	* @Annotation\Required(true)
	*/
	public $module_name;


	/**
	* @ORM\Column(type="string");
	* @Annotation\Type("Zend\Form\Element\Select")
	* @Annotation\Required(true)
	* @Annotation\Options({"label":"Select text:", "listed":true})
	*/
	public $entity;

	/**
	* Magic getter to expose protected properties.
	*
	* @param DateTime $property
	* @return mixed
	*/
	public function __get($property)
	{
		return $this->$property;
	}

	/**
	* Magic setter to save protected properties.
	*
	* @param string $property
	* @param mixed $value
	*/
	public function __set($property, $value)
	{
		$this->$property = $value;
	}

}
