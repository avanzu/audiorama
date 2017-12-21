<?php
/**
 * AudiobookController.php
 * audiorama
 * Date: 29.04.17
 */

namespace AppBundle\Controller;
use AppBundle\Form\AudiobookType;
use AppBundle\Manager\AudiobookManager;
use AppBundle\Traits\TemplateAware as TemplateTrait;
use Components\Infrastructure\Presentation\TemplateView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class AudiobookController
 * @method AudiobookManager getManager
 */
class AudiobookController extends ResourceController implements TemplateAware
{
    use TemplateTrait;

    protected function getFormType()
    {
        return AudiobookType::class;
    }


    public function dashboardAction(Request $request)
    {
        return $this->createResponse($request, ['records' => $this->getManager()->getRecent()] );
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction( Request $request )
    {
        $pager  = $this->getManager()->getCollectionByCriteria(
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

    }


}