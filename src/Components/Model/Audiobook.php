<?php

namespace Components\Model;

use AppBundle\Model\ImageUrlProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Audiobook
 *
 */
class Audiobook
{
    /**
     * @var integer
     *
     */
    protected $id;

    /**
     * @var string
     *
     */
    protected $title;

    /**
     * @var string
     * })
     */
    protected $canonical;

    /**
     * @var string
     *
     */
    protected $description;

    /**
     * @var string
     *
     */
    protected $episode;

    /**
     * @var \DateTime
     *
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     */
    protected $updatedAt;

    /**
     * @var string
     *
     */
    protected $coverImage;

    /**
     * @var string
     *
     */
    protected $storageType;

    /**
     * @var \Components\Model\Genre
     *
     */
    protected $genre;

    /**
     * @var \Components\Model\Series
     *
     */
    protected $series;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $authors;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     */
    protected $speakers;

    /**
     * Constructor
     */
    public function __construct() {
        $this->authors   = new ArrayCollection();
        $this->speakers  = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     * ("id")
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Audiobook
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     * ("title")
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Audiobook
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     * ("description")
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set episode
     *
     * @param string $episode
     * @return Audiobook
     */
    public function setEpisode($episode)
    {
        $this->episode = $episode;

        return $this;
    }

    /**
     * Get episode
     *
     * @return string
     * ("episode")
     */
    public function getEpisode()
    {
        return $this->episode;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Audiobook
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     * ("createdAt", type="datetime")
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Audiobook
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     * ("updatedAt", type="datetime")
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set coverImage
     *
     * @param string $coverImage
     * @return Audiobook
     */
    public function setCoverImage($coverImage)
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    /**
     * Get coverImage
     *
     * @return string
     * ("coverImage")
     */
    public function getCoverImage()
    {
        return $this->coverImage;
    }

    /**
     *
     * @return type
     * ("genre")
     */
    public function getGenre() {
        return $this->genre;
    }

    /**
     * @param $genre
     *
     * @return $this
     */
    public function setGenre($genre) {
        $this->genre = $genre;
        return $this;
    }
    /**
     *
     * @return type
     * ("series")
     */
    public function getSeries() {
        return $this->series;
    }

    /**
     *
     * @param type $series
     * @return \Components\Model\Audiobook
     *
     */
    public function setSeries($series) {
        $this->series = $series;
        return $this;
    }

    /**
     * @return ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getAuthors() {
        return $this->authors;
    }

    /**
     * @param $author
     *
     * @return $this
     */
    public function addAuthor($author) {
        $this->authors->add($author);
        return $this;
    }

    /**
     * @return ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getSpeakers() {
        return $this->speakers;
    }

    /**
     * @param $speaker
     *
     * @return $this
     */
    public function addSpeaker($speaker) {
        $this->speakers->add($speaker);
        return $this;
    }


    /**
     *
     * @return array
     * ("authors", type="array")
     */
    public function getAuthorList() {

        $authors = array();
        foreach($this->authors as $author) {
            $authors[] = array(
                'id' => $author->getId(),
                'fullName' => (string)$author);
        }

        return $authors;
    }

    /**
     * @return array
     */
    public function getAuthorNames() {
        $names = array();
        foreach($this->authors as $author) {
            $names[] = (string)$author;
        }
        return $names;
    }

    /**
     * @return array
     */
    public function getSpeakerNames() {
        $names = array();
        foreach($this->speakers as $speaker) {
            $names[] = (string)$speaker;
        }
        return $names;
    }

    /**
     *
     * @return type
     * ("speakers", type="array")
     */
    public function getSpeakerList() {
        $speakers = array();
        foreach($this->speakers as $speaker) {
            $speakers[] = array('id' => $speaker->getId(),
                                'fullName' => (string)$speaker);
        }

        return $speakers;

    }

    /**
     * @return bool
     */
    public function hasCoverArt() {
        return (strlen($this->coverImage) > 0);
    }

    /**
     *
     * @return string
     */
    public function getStorageType() {
        return $this->storageType;
    }

    /**
     *
     * @param string $storageType
     * @return \Components\Model\Audiobook
     */
    public function setStorageType($storageType) {
        $this->storageType = $storageType;
        return $this;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return (string)$this->title;
    }

    /**
     * @return string
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @param string $canonical
     *
     * @return $this
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->getCoverImage();
    }

    /**
     * @return bool
     */
    public function hasImageUrl()
    {
        return $this->hasCoverArt();
    }


}

