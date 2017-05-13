<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Author
 *
 * @ORM\Table(name="books_author")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Author extends Person
{
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Audiobook")
     * @ORM\JoinTable(name="books_audiobook_authors",
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="audiobook_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   joinColumns={
     *     @ORM\JoinColumn(name="author_id", referencedColumnName="id", onDelete="CASCADE")
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

