<?php
/**
 * AuthorController.php
 * audiorama
 * Date: 14.05.17
 */

namespace AppBundle\Controller;


use AppBundle\Form\AuthorType;

class AuthorController extends PersonController
{
    protected function getFormType()
    {
        return AuthorType::class;
    }


}