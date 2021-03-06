<?php
/**
 * ObjectManager.php
 * restfully
 * Date: 08.04.17
 */

namespace AppBundle\Manager;


use AppBundle\Repository\ResourceRepository;
use Components\DataAccess\Criteria;
use Components\DataAccess\ResourceCollection;
use Components\Resource\IManager;
use Components\Resource\Repository\IFactory as RepositoryFactory;
use Components\Resource\Repository\IRepository;
use Components\Resource\Validator\IResult;
use Components\Resource\Validator\IValidator;
use AppBundle\Pagination\Pager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ResourceIManager
 */
class ResourceManager implements IManager
{
    const INTENT_CREATE = 'create';
    const INTENT_UPDATE = 'update';
    const INTENT_REMOVE = 'delete';

    /**
     * @var string
     */
    protected $className;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var RepositoryFactory
     */
    protected $repositoryFactory;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * ResourceIManager constructor.
     *
     * @param string            $className
     * @param RepositoryFactory $factory
     * @param EntityManager     $entityManager
     * @param IValidator        $validator
     */
    public function __construct(
        $className,
        RepositoryFactory $factory,
        IValidator $validator,
        EntityManager $entityManager
    ) {
        $this->className         = $className;
        $this->entityManager     = $entityManager;
        $this->validator         = $validator;
        $this->repositoryFactory = $factory;
    }

    /**
     * @param      $model
     * @param null $groups
     * @param null $constraints
     *
     * @return IResult
     */
    public function validate($model, $groups=null, $constraints = null)
    {
        return $this->getValidator()->validate($model,$constraints, $groups);
    }

    /**
     * @param array $properties
     *
     * @return mixed
     */
    public function createNew($properties = [])
    {
        $class = $this->getClassName();
        $model = new $class;

        return $this->initialize($model, $properties);
    }

    /**
     * @param array|object $models
     * @param bool         $flush
     * @param null         $intent
     */
    public function save($models = [], $flush = true, $intent = null)
    {

        if( ! is_array($models) ) {
            $models = [$models];
        }

        $em = $this->getEntityManager();
        foreach($models as $model) {
            $this->preProcess($model, $intent);
            $em->persist($model);
            $this->postProcess($model, $intent);
        }

        if( $flush ) $em->flush();

    }

    /**
     * @param array|object $models
     * @param bool         $flush
     * @param null         $intent
     */
    public function remove($models = [], $flush = true, $intent = null)
    {
        if( ! is_array($models) ) {
            $models = [$models];
        }

        $em = $this->getEntityManager();
        foreach($models as $model) {
            $em->remove($model);
        }

        if( $flush ) $em->flush();
    }

    /**
     * @return int
     */
    public function getNumberOfRecords()
    {
        return $this->getRepository()
                    ->createQueryBuilder('num')
                    ->select('count(num)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function getCollectionByCriteria($page = 1, $items = 10, $term = '', $sortBy = '', $sort = 'ASC') {

        $builder = $this->getRepository()->getBuilderForCriteria($term, $sortBy, $sort);
        $pager   = new Pagerfanta(new DoctrineORMAdapter($builder, false));
        $pager->setMaxPerPage($items)->setCurrentPage($page);
        return new Pager($pager);

    }

    /**
     * @param $model
     * @param $intent
     */
    protected function preProcess($model, $intent)
    {}

    /**
     * @param $model
     * @param $intent
     */
    protected function postProcess($model, $intent)
    {}

    /**
     * @param       $model
     * @param array $properties
     *
     * @return mixed
     */
    public function initialize($model, $properties = [])
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        foreach($properties as $propertyName => $property) {
            if( ! $accessor->isWritable($model, $propertyName) ) {
                continue;
            }
            $accessor->setValue($model, $propertyName, $property);
        }
        return $model;
    }

    /**
     * @param int  $limit
     * @param int  $offset
     * @param Criteria[]|null $criteriaList
     *
     * @return ResourceCollection
     */
    public function getCollection($limit, $offset = 0, $criteriaList = null)
    {
        $builder = $this->getRepository()->createQueryBuilder('collection');
        $this->applyCriteria($criteriaList, $builder);
        $builder->setMaxResults($limit)->setFirstResult($offset);
        $pager = new Paginator($builder);

        return new ResourceCollection($pager->getIterator(), count($pager), $limit, $offset);
    }

    /**
     * @param Criteria[] $criteriaList
     * @param QueryBuilder $builder
     *
     * @return QueryBuilder
     */
    protected function applyCriteria($criteriaList, QueryBuilder $builder)
    {
        if( is_null($criteriaList) ) return $builder;
        $prefix = current($builder->getRootAliases());
        $expr   = $builder->expr();
        $params = [];
        foreach($criteriaList as $outerIndex => $criteria) {
            $items = [];
            $methodName = sprintf('%sX', strtolower($criteria->getCombination()));
            foreach($criteria->getCriteria() as $innerIndex => $criterion) {
                $property       = sprintf('%s.%s', $prefix, $criterion->getProperty());
                $param          = sprintf(':%d_%d_%s', $outerIndex, $innerIndex, $criterion->getProperty());
                $params[$param] = $criterion->getValue();
                $items[]        = call_user_func([$expr, $criterion->getComparison()], $property, $param);
            }
            $combination = call_user_func([$expr, $methodName], $items);
            $builder->andWhere($combination);
        }

        return $builder->setParameters($params);
    }


    /**
     * @return ResourceRepository|IRepository
     */
    public function getRepository()
    {
        return $this->repositoryFactory->getRepository($this->className);
    }

    /**
     * @return IValidator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     */
    public function startTransaction()
    {
        $this->getEntityManager()->beginTransaction();
    }

    /**
     *
     */
    public function cancelTransaction()
    {
        $this->getEntityManager()->rollback();
    }

    /**
     *
     */
    public function commitTransaction()
    {
        $this->getEntityManager()->commit();
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