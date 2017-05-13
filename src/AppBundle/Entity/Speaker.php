<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Speaker
 *
 * @ORM\Table(name="books_speaker")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Speaker extends Person
{
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Audiobook")
     * @ORM\JoinTable(name="books_audiobook_speakers",
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="audiobook_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   joinColumns={
     *     @ORM\JoinColumn(name="speaker_id", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    protected $books;

    /**
     * @return ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
    }

}

