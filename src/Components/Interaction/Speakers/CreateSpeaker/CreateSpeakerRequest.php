<?php
/**
 * CreateSpeakerRequest.php
 * audiorama
 * Date: 09.11.17
 */

namespace Components\Interaction\Speakers\CreateSpeaker;


use Components\Interaction\Resource\CreateResource\CreateResourceRequest;

class CreateSpeakerRequest extends CreateResourceRequest
{

    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'speaker';
    }
}