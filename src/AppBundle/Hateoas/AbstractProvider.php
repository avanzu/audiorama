<?php
/**
 * AbstractProvider.php
 * audiorama
 * Date: 01.05.17
 */

namespace AppBundle\Hateoas;


use Components\Hateoas\RelationProviderInterface;
use Symfony\Component\Routing\Router;

abstract class AbstractProvider implements RelationProviderInterface
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * PagerRelationProvider constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router) { $this->router = $router; }

    /**
     * @param       $route
     * @param array $params
     *
     * @return string
     */
    protected function getUrl($route, $params = [])
    {
        return $this->router->generate($route, $params);
    }


}