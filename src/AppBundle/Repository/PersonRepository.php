<?php
/**
 * PersonRepository.php
 * audiorama
 * Date: 02.05.17
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class PersonRepository extends EntityRepository
{

    public function getBuilderForCriteria($term = '', $sortBy = 'firstName', $sort = 'ASC')
    {
        $builder = $this->createQueryBuilder('person');


        $builder->addOrderBy(sprintf('person.%s', $sortBy), $sort);

        if( 0 === strlen($term) ) {
            return $builder;
        }

        $expr     = $builder->expr();
        $criteria = $expr->orX();
        $criteria
            ->add($expr->like('person.firstName', ':term'))
            ->add($expr->like('person.lastName', ':term'))
            ;
        $builder->andWhere($criteria)->setParameter('term', "%$term%");

        return $builder;
    }

}