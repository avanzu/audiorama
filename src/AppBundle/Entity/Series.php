<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Series
 *
 * @ORM\Table(name="books_series")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AttributeRepository")
 */
class Series extends Attribute
{
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Audiobook", mappedBy="series", cascade={"persist"})
     */
    protected $books;
}

