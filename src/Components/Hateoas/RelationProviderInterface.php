<?php
/**
 * RelationProviderInterface.php
 * restfully
 * Date: 14.04.17
 */

namespace Components\Hateoas;


use Symfony\Component\HttpFoundation\Request;

interface RelationProviderInterface
{

    /**
     * @param $object
     *
     * @return array
     */
    public function decorate($object, Request $request = null);

    /**
     * @param $object
     *
     * @return bool
     */
    public function isSupported($object);

}