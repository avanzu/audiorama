<?php
/**
 * AudiobookController.php
 * audiorama
 * Date: 29.04.17
 */

namespace AppBundle\Controller;
use AppBundle\Manager\AudiobookManager;
use AppBundle\Traits\TemplateAware as TemplateTrait;
use FOS\ElasticaBundle\Paginator\FantaPaginatorAdapter;
use FOS\RestBundle\View\View;
use Pagerfanta\Adapter\ElasticaAdapter;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class AudiobookController
 * @method AudiobookManager getManager
 */
class AudiobookController extends ResourceController implements TemplateAware
{
    use TemplateTrait;

    /**
     * @param int     $page
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction( Request $request )
    {
        $pager  = $this->getManager()->getBooksByCriteria(
            $request->get('page', 1),
            $request->get('items', 10),
            $request->get('term', ''),
            $request->get('sort', 'title'),
            $request->get('dir', 'ASC')
        );


        $responseData = [
            'result'   => $pager,
            'sortable' => $this->getManager()->getSortableFields(),
            'query'    => $request->query->all(),
            'sorted'   => $request->get('sort', 'title')
        ];


        return $this->createResponse($request, $responseData);

        // return $this->render($this->getTemplate(), );
    }

    public function showAction(Request $request)
    {


    }

}