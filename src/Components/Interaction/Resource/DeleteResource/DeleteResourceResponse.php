<?php
/**
 * CreateResourceResponse.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource\DeleteResource;


use Components\Infrastructure\Response\IResponse;
use Components\Interaction\Resource\ResourceRequest;
use Components\Interaction\Resource\ResourceResponse;

class DeleteResourceResponse extends ResourceResponse
{
    public function __construct($resource, ResourceRequest $request, $status = IResponse::STATUS_CREATED)
    {
        parent::__construct($resource, $request, $status);
    }


}