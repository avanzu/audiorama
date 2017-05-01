<?php
/**
 * Pager.php
 * audiorama
 * Date: 01.05.17
 */

namespace AppBundle\Pagination;


use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Pager
 *
 */
class Pager implements \IteratorAggregate
{
    /**
     * @var Pagerfanta
     * @Serializer\Exclude
     * @Serializer\AccessType("public_method")
     */
    protected $pager;

    /**
     * Pager constructor.
     *
     * @param $pager
     */
    public function __construct($pager) { $this->pager = $pager; }


    /**
     * @Serializer\VirtualProperty
     */
    public function getNbResults()
    {
       return  $this->pager->getNbResults();
    }


    /**
     * @return int
     * @Serializer\VirtualProperty
     */
    public function getPages()
    {
        return $this->pager->getNbPages();
    }

    /**
     * @return int
     * @Serializer\VirtualProperty
     */
    public function getPage()
    {
        return $this->pager->getCurrentPage();
    }

    /**
     * @return int
     * @Serializer\VirtualProperty
     */
    public function getNextPage()
    {
        if( $this->isLastPage() ) {
            return false;
        }

        return $this->pager->getNextPage();
    }

    /**
     * @return int
     * @Serializer\VirtualProperty
     */
    public function getPreviousPage()
    {
        if( $this->isFirstPage() ) {
            return false;
        }

        return $this->pager->getPreviousPage();
    }

    /**
     * @return array|\Traversable
     * @Serializer\VirtualProperty
     */
    public function getItems()
    {
        return $this->pager->getCurrentPageResults();
    }

    /**
     * @return int
     * @Serializer\VirtualProperty
     */
    public function getItemsPerPage()
    {
        return $this->pager->getMaxPerPage();
    }

    /**
     * @return array|\ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return $this->pager->getIterator();
    }

    /**
     * @return Pagerfanta
     */
    public function getPager()
    {
        return $this->pager;
    }

    /**
     * @return bool
     */
    public function isFirstPage()
    {
        return ($this->pager->getCurrentPage() == 1);
    }

    /**
     * @return bool
     */
    public function isLastPage()
    {
        return ($this->pager->getNbPages() == $this->pager->getCurrentPage());
    }
}
