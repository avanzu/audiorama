<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;


/**
 * Author
 */
class Author extends Person
{
    /**
     * @var ArrayCollection
     * @Serializer\Exclude()
     */
    protected $books;

    /**
     * @return ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
    }
}

