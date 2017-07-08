<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Genre
 *
 * @ORM\Table(name="books_genre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AttributeRepository")
 */
class Genre extends Attribute
{
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Audiobook", mappedBy="genre", cascade={"persist"})
     */
    protected $books;
}

