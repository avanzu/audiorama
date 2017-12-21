<?php
/**
 * CreateResourceResponse.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource\UpdateResource;


use Components\Infrastructure\Response\IResponse;
use Components\Interaction\Resource\ResourceRequest;
use Components\Interaction\Resource\ResourceResponse;

class UpdateResourceResponse extends ResourceResponse
{
    public function __construct($resource, ResourceRequest $request, $status = IResponse::STATUS_OK)
    {
        parent::__construct($resource, $request, $status);
    }


}