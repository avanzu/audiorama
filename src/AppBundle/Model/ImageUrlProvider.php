<?php
/**
 * ImageUrlProvider.php
 * audiorama
 * Date: 13.05.17
 */

namespace AppBundle\Model;


interface ImageUrlProvider
{
    public function getImageUrl();

    public function hasImageUrl();
}