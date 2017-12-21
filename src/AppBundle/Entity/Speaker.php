<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Speaker
 *
 */
class Speaker extends Person
{
    /**
     * @var ArrayCollection
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

