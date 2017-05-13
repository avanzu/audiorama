<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Genre
 *
 * @ORM\Table(name="books_genre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AttributeRepository")
 */
class Genre extends Attribute
{

}

