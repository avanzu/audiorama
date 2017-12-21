<?php
/**
 * AttributeMeta.php
 * audiorama
 * Date: 15.05.17
 */

namespace Components\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AttributeMeta
 */
class AttributeMeta
{

    /**
     * @var Attribute
     */
    protected $attribute;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
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