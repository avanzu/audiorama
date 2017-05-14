<?php
/**
 * SpeakerController.php
 * audiorama
 * Date: 14.05.17
 */

namespace AppBundle\Controller;


use AppBundle\Form\SpeakerType;

class SpeakerController extends PersonController
{
    protected function getFormType()
    {
        return SpeakerType::class;
    }


}