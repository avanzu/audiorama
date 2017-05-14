<?php
/**
 * SeriesController.php
 * audiorama
 * Date: 14.05.17
 */

namespace AppBundle\Controller;


use AppBundle\Form\GenreType;
use AppBundle\Form\SeriesType;

class GenreController extends AttributeController
{
    protected function getFormType()
    {
        return GenreType::class;
    }

}