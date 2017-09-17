<?php
/**
 * StatsManager.php
 * audiorama
 * Date: 10.07.17
 */

namespace AppBundle\Manager;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class StatsManager implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container = null;


    public function getPublicStats()
    {
        $stats = [];

        foreach($this->getPublicResources() as $name => $manager) {
            $stats[$name] = $this->getManager($manager)->getNumberOfRecords();
        }

        return $stats;
    }


    /**
     * @param $name
     *
     * @return ResourceManager|null
     */
    protected function getManager($name)
    {
        return $this->container->get($name);
    }

    protected function getPublicResources()
    {
        return $this->container->getParameter('app.resources.public');
    }


    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}