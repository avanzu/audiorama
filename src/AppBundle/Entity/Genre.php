<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Genre
 *
 */
class Genre extends Attribute
{
    /**
     * @var ArrayCollection
     */
    protected $books;
}

