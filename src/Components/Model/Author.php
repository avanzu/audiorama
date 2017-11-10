<?php

namespace Components\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Author
 *
 */
class Author extends Person
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

