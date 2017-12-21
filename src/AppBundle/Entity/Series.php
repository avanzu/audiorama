<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Series
 *
 */
class Series extends Attribute
{
    /**
     * @var ArrayCollection
     */
    protected $books;
}

