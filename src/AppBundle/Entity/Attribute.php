<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;


/**
 * Attribute
 *
 * @ORM\Table(name="books_attribute")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="nature", type="string")
 * @ORM\DiscriminatorMap({
 *     "attribute" = "AppBundle\Entity\Attribute",
 *     "genre" = "AppBundle\Entity\Genre",
 *     "series" = "AppBundle\Entity\Series"
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AttributeRepository")
 */
class Attribute
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     * @ORM\Column(name="canonical", type="string", length=255, nullable=true)
     * @Gedmo\Slug(fields={"name"})
     */
    protected $canonical;

    /**
     * @var ArrayCollection
     */
    protected $books;

    /**
     * @var ArrayCollection|AttributeMeta[]
     * @ORM\OneToMany(targetEntity="AttributeMeta", indexBy="name", mappedBy="attribute")
     */
    protected $meta;

    /**
     * Attribute constructor.
     */
    public function __construct() {
        $this->books = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Attribute
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @return string
     * @VirtualProperty
     */
    public function getDisplay()
    {
        return $this->__toString();
    }

    /**
     * @return int
     */
    public function getOccurrences()
    {
        return $this->books->count();
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function setMeta($key, $value)
    {
        $meta = new AttributeMeta($this);
        $meta->setName($key)->setValue($value);
        $this->meta->set($key, $meta);
        return $this;
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function getMeta($key, $default = null)
    {
        return $this->meta->containsKey($key) ? $this->meta->get($key) : $default;
    }
}

