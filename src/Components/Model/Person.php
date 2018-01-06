<?php

namespace Components\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Exclude;

/**
 * Person
 *
 */
class Person
{
    const SORT_DEFAULT = 'firstName';

    /**
     * @var integer
     *
     */
    protected $id;

    /**
     * @var string
     *
     */
    protected $firstName;

    /**
     * @var string
     *
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $canonical;

    /**
     * @var ArrayCollection
     * @Exclude
     */
    protected $books;

    /**
     * Person constructor.
     */
    public function __construct() {
        $this->books = new ArrayCollection();
    }


    /**
     * @return ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @return int
     */
    public function getOccurrences()
    {
        return $this->books->count();
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
}

