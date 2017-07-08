<?php
/**
 * AttributeMeta.php
 * audiorama
 * Date: 15.05.17
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AttributeMeta
 * @ORM\Table(name="books_attribute_meta")
 * @ORM\Entity
 */
class AttributeMeta
{

    /**
     * @var Attribute
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Attribute", inversedBy="meta")
     */
    protected $attribute;

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="name")
     */
    protected $name;

    /**
     * @var mixed
     * @ORM\Column(name="value")
     */
    protected $value;

    /**
     * AttributeMeta constructor.
     *
     * @param Attribute $attribute
     */
    public function __construct(Attribute $attribute) { $this->attribute = $attribute; }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

}