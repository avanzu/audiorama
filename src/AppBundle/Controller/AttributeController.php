<?php
/**
 * AttributeController.php
 * audiorama
 * Date: 14.05.17
 */

namespace AppBundle\Controller;


use AppBundle\Manager\AttributeManager;
use AppBundle\Manager\AudiobookManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Traits\TemplateAware as TemplateTrait;

/**
 * Class AttributeController
 * @method AttributeManager getManager
 */
class AttributeController extends ResourceController implements TemplateAware
{
    use TemplateTrait;

    public function indexAction(Request $request)
    {
        $pager = $this->getManager()->getAttributesByCriteria(
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

    public function createAction(Request $request)
    {
        $model   = $this->getManager()->createNew();
        $form    = $this->createForm($this->getFormType(), $model);
        $status  = $this->handleForm($request, $form, $model, AudiobookManager::INTENT_CREATE);
        if( Response::HTTP_ACCEPTED === $status ){
            $this->getManager()->save($model);
            $status = Response::HTTP_CREATED;

            if( $redirect = $this->getRedirectFromRequest($request, $model) ) {
                return $redirect;
            }
        }

        return $this->createResponse($request, [
            'form'  => $form->createView(),
            'model' => $model,
        ], $status);

    }

    /**
     * @param         $canonical
     * @param Request $request
     *
     * @return Response
     */
    public function showAction($canonical, Request $request)
    {
        $model = $this->getManager()->getByCanonical($canonical);
        $this->throw404Unless($model);

        return $this->createResponse($request, ['record' => $model]);
    }
}