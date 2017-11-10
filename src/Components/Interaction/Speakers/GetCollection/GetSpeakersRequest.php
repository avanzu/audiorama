<?php
/**
 * GetSpeakersRequest.php
 * audiorama
 * Date: 09.11.17
 */

namespace Components\Interaction\Speakers\GetCollection;


use Components\Interaction\Resource\GetCollection\GetCollectionRequest;
use Components\Model\Speaker;

class GetSpeakersRequest extends GetCollectionRequest
{

    protected $sortBy = Speaker::SORT_DEFAULT;

    public function getResourceName()
    {
        return 'speaker';
    }

}