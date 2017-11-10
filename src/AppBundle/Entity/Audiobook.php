<?php

namespace AppBundle\Entity;

use AppBundle\Model\ImageUrlProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Audiobook
 */
class Audiobook extends \Components\Model\Audiobook implements ImageUrlProvider
{

}

