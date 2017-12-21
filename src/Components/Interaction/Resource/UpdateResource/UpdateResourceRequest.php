<?php
/**
 * CreateResourceRequest.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource\UpdateResource;


use Components\Interaction\Resource\ResourceRequest;

abstract class UpdateResourceRequest extends ResourceRequest
{
    public function getIntention()
    {
        return 'update';
    }


}