<?php
/**
 * CreateResourceRequest.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource\DeleteResource;


use Components\Interaction\Resource\ResourceRequest;

abstract class DeleteResourceRequest extends ResourceRequest
{
    public function getIntention()
    {
        return 'delete';
    }


}