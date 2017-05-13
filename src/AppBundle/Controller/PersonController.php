<?php
/**
 * PersonController.php
 * audiorama
 * Date: 13.05.17
 */

namespace AppBundle\Controller;


use AppBundle\Manager\PersonManager;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Traits\TemplateAware as TemplateTrait;

/**
 * Class PersonController
 * @method PersonManager getManager
 */
class PersonController extends ResourceController implements TemplateAware
{
    use TemplateTrait;

    public function indexAction(Request $request)
    {
        $pager = $this->getManager()->getPersonsByCriteria(
            $request->get('page', 1),
            $request->get('items', 10),
            $request->get('term', ''),
            $request->get('sort', 'firstName'),
            $request->get('dir', 'ASC')
        )
        ;

        $responseData = [
            'result'   => $pager,
            'sortable' => $this->getManager()->getSortableFields(),
            'query'    => $request->query->all(),
            'sorted'   => $request->get('sort', 'firstName')
        ];

        return $this->createResponse($request, $responseData);
    }
}