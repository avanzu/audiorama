<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Author
 *
 * @ORM\Table(name="books_author")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Author extends Person
{

}

