<?php
/**
 * SeriesController.php
 * audiorama
 * Date: 14.05.17
 */

namespace AppBundle\Controller;


use AppBundle\Form\SeriesType;

class SeriesController extends AttributeController
{
    protected function getFormType()
    {
        return SeriesType::class;
    }

}