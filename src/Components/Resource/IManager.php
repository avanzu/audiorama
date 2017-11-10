<?php
/**
 * IManager.phpp
 * restfully
 * Date: 16.09.17
 */

namespace Components\Resource;

use Components\DataAccess\Criteria;
use Components\Resource\Repository\IRepository;
use Components\Resource\Validator\IResult;
use Components\Resource\Validator\IValidator;

/**
 * Class ResourceIManager
 */
interface IManager
{
    /**
     * @param      $model
     * @param null $groups
     * @param null $constraints
     *
     * @return IResult
     */
    public function validate($model, $groups = null, $constraints = null);

    /**
     * @param array $properties
     *
     * @return mixed
     */
    public function createNew($properties = []);

    /**
     * @param array|object $models
     * @param bool         $flush
     * @param null         $intent
     */
    public function save($models = [], $flush = true, $intent = null);

    /**
     * @param array|object $models
     * @param bool         $flush
     * @param null         $intent
     */
    public function remove($models = [], $flush = true, $intent = null);

    /**
     * @param       $model
     * @param array $properties
     *
     * @return mixed
     */
    public function initialize($model, $properties = []);

    /**
     * @param  int     $limit
     * @param  int     $offset
     * @param Criteria[] $criteria
     *
     * @return mixed
     */
    public function getCollection($limit, $offset = 0, $criteria = null);

    /**
     * @param int    $page
     * @param int    $items
     * @param string $term
     * @param string $sortBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getCollectionByCriteria($page = 1, $items = 10, $term = '', $sortBy = '', $sort = 'ASC');

    /**
     * @return array
     */
    public function getSortableFields();

    /**
     * @return IRepository
     */
    public function getRepository();

    /**
     * @return IValidator
     */
    public function getValidator();

    /**
     * @return string
     */
    public function getClassName();

    /**
     * @return void
     */
    public function startTransaction();

    /**
     * @return void
     */
    public function cancelTransaction();

    /**
     * @return void
     */
    public function commitTransaction();
}