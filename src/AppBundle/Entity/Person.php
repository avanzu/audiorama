<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Person
 *
 * @ORM\Table(name="books_person")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="role", type="string")
 * @ORM\DiscriminatorMap({
 *     "person" = "AppBundle\Entity\Person",
 *     "author" = "AppBundle\Entity\Author",
 *     "speaker" = "AppBundle\Entity\Speaker"
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Person
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
     * @ORM\Column(name="firstName", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(name="canonical", type="string", length=255, nullable=true)
     * @Gedmo\Slug(fields={"firstName", "lastName"})
     */
    protected $canonical;

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
     * Set firstName
     *
     * @param string $firstName
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    public function setFullNameReverse($fullNameReverse) {
        $parts = explode(',', $fullNameReverse);
        $this->lastName = trim($parts[0]);
        if(isset($parts[1])) $this->firstName = trim($parts[1]);
        return $this;

    }

    public function getFullNameReverse() {

        if(0 == strlen($this->firstName)) {
            return $this->lastName;
        }

        return $this->lastName. ', '.$this->firstName;
    }

    public function __toString() {
        return trim($this->firstName). ' '.trim($this->lastName);
    }

}

