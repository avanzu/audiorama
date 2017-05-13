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
}