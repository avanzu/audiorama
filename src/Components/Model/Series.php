<?php

namespace Components\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Series
 *
 */
class Series extends Attribute
{
    /**
     */
    protected $books;
}

