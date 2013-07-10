<?php
namespace Modules\Entity;

use Doctrine\ORM\Mapping as ORM;

use Zend\Form\Annotation;

/**
 * A movie
 *
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("RelationTest")
 * @ORM\Entity
 * @ORM\Table(name="noodle_relation")
 * @property integer $id
 * @property string $title
 * @property string $description
 */
class Relation
{

	/**
	* @ORM\Id
	* @ORM\Column(type="integer");
	* @ORM\GeneratedValue(strategy="AUTO")
	* @Annotation\Exclude()
	*/
	public $id;

	/**
	 * @ORM\Column(type="integer");
	 * @Annotation\Exclude()
	 */
	public $parent_row_id;

	/**
	 * @ORM\Column(type="integer");
	 * @Annotation\Exclude()
	 */
	public $parent_entity;

	/**
	* @ORM\Column(type="string");
	* @Annotation\Type("Zend\Form\Element\Text")
	* @Annotation\Options({"listed": true,"label":"Title:"})
	* @Annotation\Required(true)
	*/
	public $title;

	/**
	* @ORM\Column(type="string");
	* @Annotation\Type("Zend\Form\Element\Text")
	* @Annotation\Options({"label":"Description:"})
	* @Annotation\Required(false)
	*/
	public $description;

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
