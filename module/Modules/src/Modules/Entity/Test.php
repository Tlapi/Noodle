<?php
namespace Modules\Entity;

use Doctrine\ORM\Mapping as ORM;

use Zend\Form\Annotation;

/**
 * A movie
 *
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("Test")
 * @ORM\Entity(repositoryClass="\Modules\Repository\Base")
 * @ORM\Table(name="noodle_modules")
 * @property integer $id
 * @property string $name
 */
class Test extends Base
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
	* @Annotation\Options({"label":"Name:", "listed":true, "placeholder":"Nice placeholder...", "blockHelp":"Nice block help text"})
	* @Annotation\Required(true)
	*/
	public $name;


	/**
	* @ORM\OneToOne(targetEntity="\Modules\Entity\Relation")
	* @Annotation\Type("Application\Form\Element\Relation")
	* @Annotation\Required(true)
	* @Annotation\Options({"label":"Select text:", "relationColumn":"title", "targetEntity":"\Modules\Entity\Relation", "listed":true})
	*/
	public $select;

	/**
	* @ORM\Column(type="string");
	* @Annotation\Type("Zend\Form\Element\Text")
	* @Annotation\Options({"label":"Title:"})
	* @Annotation\Required(false)
	*/
	public $title;

	/**
	* @ORM\Column(type="integer");
	* @Annotation\Type("Application\Form\Element\Picture")
	* @Annotation\Options({"label":"Picture:"})
	* @Annotation\Required(false)
	*/
	public $picture;

	/**
	 * @Annotation\Options({"label":"My sheet", "sheetType": "cyclic", "targetEntity":"\Modules\Entity\Relation"})
	 * @Annotation\Required(false)
	 */
	public $sheet;

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
