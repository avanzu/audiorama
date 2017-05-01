<?php
/**
 * AudiobookManager.php
 * audiorama
 * Date: 29.04.17
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Audiobook;
use AppBundle\Pagination\Pager;
use AppBundle\Repository\AudiobookRepository;
use Elastica\Query;
use Gedmo\Sluggable\Util\Urlizer;
use Pagerfanta\Pagerfanta;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Class AudiobookManager
 * @method AudiobookRepository getRepository
 */
class AudiobookManager extends ResourceManager implements ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @return int
     */
    public function getItemsTotal()
    {
        return $this->getRepository()->countItems();
    }

    /**
     * @param callable $callback
     */
    public function updateCanonicals(callable $callback)
    {
        $this->getRepository()->findAndMapAll(function(Audiobook $entity) use ($callback) {
            $entity->setCanonical(Urlizer::urlize($entity->getTitle()))->setUpdatedAt(new \DateTime());
            call_user_func($callback, $entity);
            $this->save($entity);

        });
    }



    /**
     * @param int    $page
     * @param int    $items
     * @param string $sortBy
     * @param string $sort
     *
     * @return Pager
     */
    public function getBooksByCriteria($page = 1, $items = 10, $term = '', $sortBy = 'title', $sort = 'ASC')
    {
        $queryString  = $term ? new Query\QueryString($term) : null;
        $query = new Query($queryString);
        $query->addSort([$sortBy => ['order' => $sort]]);
        return new Pager(
            $this
            ->getFinder()
            ->findPaginated($query)
            ->setMaxPerPage($items)
            ->setCurrentPage($page)
        )
            ;

        // return $this->getRepository()->findAllPagedSorted($page, $items, $sortBy, $sort);
    }


    /**
     * @return array
     */
    public function getSortableFields()
    {
        $mapping = $this->container->get('fos_elastica.index_manager')->getIndex('app')->getMapping();
        return array_keys($mapping['book']['properties']);
        // return $this->getEntityManager()->getClassMetadata($this->getClassName())->getFieldNames();
    }

    /**
     * @return \FOS\ElasticaBundle\Finder\TransformedFinder
     */
    protected function getFinder()
    {
        return $this->container->get('fos_elastica.finder.app.book');
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