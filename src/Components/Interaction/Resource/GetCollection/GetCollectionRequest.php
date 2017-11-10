<?php
/**
 * GetCollectionRequest.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Interaction\Resource\GetCollection;


use Components\DataAccess\Criteria;
use Components\Interaction\Resource\ResourceRequest;

class GetCollectionRequest extends ResourceRequest
{

    protected $limit   = 10;
    protected $page    = 1;
    protected $term    = '';
    protected $sortBy  = '';
    protected $sortDir = 'ASC';
    protected $resourceName;


    /**
     * GetCollectionRequest constructor.
     *
     * @param null       $dao
     * @param            $resourceName
     * @param int        $limit
     * @param null       $page
     * @param string     $term
     * @param string     $sortBy
     * @param string     $sortDir
     *
     * @internal param int $offset
     * @internal param Criteria[] $criteria
     */
    public function __construct(
        $dao = null,
        $resourceName = null,
        $limit = 10,
        $page = null,
        $term = '',
        $sortBy = '',
        $sortDir = 'ASC'
    ) {
        $this->limit        = $limit;
        $this->resourceName = $resourceName;
        parent::__construct($dao);
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return string
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @param string $term
     *
     * @return $this
     */
    public function setTerm($term)
    {
        $this->term = $term;

        return $this;
    }

    /**
     * @return string
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * @param string $sortBy
     *
     * @return $this
     */
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;

        return $this;
    }

    /**
     * @return string
     */
    public function getSortDir()
    {
        return $this->sortDir;
    }

    /**
     * @param string $sortDir
     *
     * @return $this
     */
    public function setSortDir($sortDir)
    {
        $this->sortDir = $sortDir;

        return $this;
    }


    /**
     * @return string
     */
    public function getIntention()
    {
        return 'list';
    }

    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        return $this->dao;
    }

}