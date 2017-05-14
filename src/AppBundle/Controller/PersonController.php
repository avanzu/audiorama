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
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Traits\TemplateAware as TemplateTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PersonController
 * @method PersonManager getManager
 */
class PersonController extends ResourceController implements TemplateAware
{
    use TemplateTrait;

    protected function getFormType()
    {
        return FormType::class;
    }


    protected function getRedirect()
    {
        return null;
    }

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