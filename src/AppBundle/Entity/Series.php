<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Series
 *
 * @ORM\Table(name="books_series")
 * @ORM\Entity(repositoryClass="AppBundle\Doctrine\Extensions\EntityRepository")
 */
class Series extends Attribute
{

}

