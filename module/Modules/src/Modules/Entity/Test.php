<?php
namespace Modules\Entity;

use Doctrine\ORM\Mapping as ORM;

use Zend\Form\Annotation;

/**
 * A movie
 *
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("Test")
 * @ORM\Entity
 * @ORM\Table(name="modules")
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
	* @ORM\Column(type="string");
	* @Annotation\Type("Zend\Form\Element\Text")
	* @Annotation\Options({"label":"Name:"})
	* @Annotation\Required(true)
	* @ListedAnnotation("name", dataType="string")	
	*/
	public $name;
	
	/**
	 * @ORM\Column(type="integer");
	 * @Annotation\Exclude()
	 */
	public $select_id;
	
	/**
	* @ORM\OneToOne(targetEntity="\Modules\Entity\Relation")
	* @Annotation\Type("Application\Form\Element\Relation")
	* @Annotation\Options({"label":"Select text:"})
	* @Annotation\Required(true)
	* @Annotation\Options({"relationColumn":"relcol"})
	* @ListedAnnotation("name", dataType="string")
	* @RelationAnnotation("title")		
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