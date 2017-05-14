<?php
/**
 * AttributeRepository.php
 * audiorama
 * Date: 04.05.17
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AttributeRepository extends EntityRepository
{

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getChoiceBuilder()
    {
        return $this->createQueryBuilder('attribute')->addOrderBy('attribute.name', 'ASC');
    }

    /**
     * @param string $term
     * @param string $sortBy
     * @param string $sort
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getBuilderForCriteria($term = '', $sortBy = 'firstName', $sort = 'ASC') {
        $builder = $this->createQueryBuilder('attribute');
        $builder->addOrderBy(sprintf('attribute.%s', $sortBy), $sort);

        if( 0 === strlen($term) ) {
            return $builder;
        }

        $expr     = $builder->expr();
        $criteria = $expr->orX();
        $criteria
            ->add($expr->like('attribute.name', ':term'))
            ->add($expr->like('attribute.description', ':term'))
        ;

        $builder->andWhere($criteria)->setParameter('term', "%$term%");

        return $builder;

    }
}