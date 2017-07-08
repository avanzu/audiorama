<?php
/**
 * AudiobookRepository.php
 * audiorama
 * Date: 29.04.17
 */

namespace AppBundle\Repository;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class AudiobookRepository extends EntityRepository
{

    /**
     * @return mixed
     */
    public function countItems()
    {
        return $this->createQueryBuilder('audiobook')->select('count(audiobook)')->getQuery()->getSingleScalarResult();
    }

    /**
     * @param callable $callback
     */
    public function findAndMapAll(callable $callback)
    {
        foreach($this->createQueryBuilder('books')->getQuery()->iterate() as $record) {
            $book = reset($record);
            call_user_func($callback, $book, $this);
        }

    }

    /**
     * @param int    $page
     * @param int    $items
     * @param string $orderBy
     * @param string $direction
     *
     * @return Paginator
     */
    public function findAllPagedSorted($page = 1, $items = 10, $orderBy = 'title', $direction = 'ASC')
    {
       $builder = $this->createQueryBuilder('audiobook')->addOrderBy(sprintf('audiobook.%s', $orderBy), $direction)
       ;
       return $this->paginate($builder, $page, $items);
    }

    /**
     * @param QueryBuilder $builder
     * @param int          $page
     * @param int          $items
     *
     * @return Pagerfanta
     */
    protected function paginate(QueryBuilder $builder, $page = 1, $items = 10)
    {
        $pager = new Pagerfanta(new DoctrineORMAdapter($builder, false));
        $pager->setCurrentPage($page)->setMaxPerPage($items);
        return $pager;
    }

    /**
     * @param $amount
     * @return ArrayCollection
     */
    public function findRecent($amount) {

        $builder = $this->createQueryBuilder('audiobook')
                        ->orderBy('audiobook.createdAt', 'desc')
                        ->setMaxResults($amount)
            ;

        return new ArrayCollection($builder->getQuery()->getResult());

    }
}