<?php
/**
 * PagerRelationProvider.php
 * audiorama
 * Date: 01.05.17
 */

namespace AppBundle\Hateoas;


use AppBundle\Pagination\Pager;
use Components\Hateoas\RelationProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

/**
 * Class PagerRelationProvider
 */
class PagerRelationProvider extends AbstractProvider
{

    /**
     * @param         Pager $object
     * @param Request $request
     *
     * @return array
     */
    public function decorate($object, Request $request = null)
    {
        $query = $request->query->all();
        $route = $request->get('_route');

        $links = [
            '_self' => $this->getUrl($route, $query),
            'first' => $this->getUrl($route, array_merge($query, ['page' => 1])),
            'last'  => $this->getUrl($route, array_merge($query, ['page' => $object->getPages()])),
        ];

        if( ! $object->isFirstPage() ) {
            $links['prev'] = $this->getUrl($route, array_merge($query, ['page' => $object->getPreviousPage()]));
        }
        if( ! $object->isLastPage() ) {
            $links['next']  = $this->getUrl($route, array_merge($query, ['page' => $object->getNextPage()]));
        }

        return $links;
    }


    /**
     * @param $object
     *
     * @return bool
     */
    public function isSupported($object)
    {
        return ($object instanceof Pager);
    }
}