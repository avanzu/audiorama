<?php
/**
 * GetCollectionResponse.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Interaction\Resource\GetCollection;


use Components\Infrastructure\Response\IResponse;
use Components\Interaction\Resource\ResourceRequest;
use Components\Interaction\Resource\ResourceResponse;

class GetCollectionResponse extends ResourceResponse
{
    protected $sortable = [];

    public function __construct(
        $resource,
        ResourceRequest $request,
        $sortable = [],
        $status = IResponse::STATUS_OK
    )
    {
        parent::__construct($resource, $request, $status);
        $this->sortable = $sortable;
    }

    /**
     * @return array
     */
    public function getSortable()
    {
        return $this->sortable;
    }

    /**
     * @param array $sortable
     *
     * @return $this
     */
    public function setSortable($sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

}