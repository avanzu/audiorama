<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Speaker
 *
 * @ORM\Table(name="books_speaker")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Speaker extends Person
{

}

