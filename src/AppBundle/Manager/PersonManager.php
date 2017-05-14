<?php
/**
 * PersonManager.php
 * audiorama
 * Date: 29.04.17
 */

namespace AppBundle\Manager;

use AppBundle\Pagination\Pager;
use AppBundle\Repository\PersonRepository;
use Elastica\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Class PersonManager
 * @method PersonRepository getRepository
 */
class PersonManager extends ResourceManager
{

    /**
     * @param int    $page
     * @param int    $items
     * @param string $term
     * @param string $sortBy
     * @param string $sort
     *
     * @return Pager
     */
    public function getPersonsByCriteria($page = 1, $items = 10, $term = '', $sortBy = 'firstName', $sort = 'ASC') {

        $builder = $this->getRepository()->getBuilderForCriteria($term, $sortBy, $sort);
        $pager   = new Pagerfanta(new DoctrineORMAdapter($builder, false));
        $pager->setMaxPerPage($items)->setCurrentPage($page);
        return new Pager($pager);

    }

    /**
     * @return array
     */
    public function getSortableFields()
    {
        return $this->getEntityManager()->getClassMetadata($this->getClassName())->getFieldNames();
    }

    /**
     * @param $canonical
     *
     * @return null|object
     */
    public function getByCanonical($canonical) {
        return $this->getRepository()->findOneBy(['canonical' => $canonical]);
    }
}