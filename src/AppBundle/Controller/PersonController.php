<?php
/**
 * PersonController.php
 * audiorama
 * Date: 13.05.17
 */

namespace AppBundle\Controller;


use AppBundle\Form\AuthorType;
use AppBundle\Manager\AudiobookManager;
use AppBundle\Manager\PersonManager;
use AppBundle\Manager\ResourceManager;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Traits\TemplateAware as TemplateTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PersonController
 * @method ResourceManager getManager
 */
class PersonController extends ResourceController implements TemplateAware
{
    use TemplateTrait;


    public function indexAction(Request $request)
    {

        $pager = $this->getManager()->getCollectionByCriteria(
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