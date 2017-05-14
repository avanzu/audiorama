<?php
/**
 * SeriesController.php
 * audiorama
 * Date: 14.05.17
 */

namespace AppBundle\Controller;


use AppBundle\Form\GenreType;

class GenreController extends AttributeController
{
    protected function getFormType()
    {
        return GenreType::class;
    }

}