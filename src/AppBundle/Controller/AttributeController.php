<?php
/**
 * AttributeController.php
 * audiorama
 * Date: 14.05.17
 */

namespace AppBundle\Controller;


use AppBundle\Manager\AudiobookManager;
use AppBundle\Manager\ResourceManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Traits\TemplateAware as TemplateTrait;

/**
 * Class AttributeController
 * @method ResourceManager getManager
 */
class AttributeController extends ResourceController implements TemplateAware
{
    use TemplateTrait;

    public function indexAction(Request $request)
    {
        $pager = $this->getManager()->getCollectionByCriteria(
            $request->get('page', 1),
            $request->get('items', 10),
            $request->get('term', ''),
            $request->get('sort', 'name'),
            $request->get('dir', 'ASC')
        )
        ;

        $responseData = [
            'result'   => $pager,
            'sortable' => $this->getManager()->getSortableFields(),
            'query'    => $request->query->all(),
            'sorted'   => $request->get('sort', 'name')
        ];

        return $this->createResponse($request, $responseData);
    }

}