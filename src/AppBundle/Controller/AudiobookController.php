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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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

    public function createAction(Request $request)
    {
        $model  = $this->getManager()->createNew();
        $form   = $this->createForm(AudiobookType::class, $model);
        $status =  $this->handleForm($request, $form, $model, AudiobookManager::INTENT_CREATE);

        if(Response::HTTP_ACCEPTED === $status ){
            $this->getManager()->save($model);
            $status = Response::HTTP_CREATED;
        }

        return $this->createResponse($request, [
            'form'  => $form->createView(),
            'model' => $model,
        ], $status);
    }

    public function editAction($canonical, Request $request)
    {
        $model = $this->getManager()->getByCanonical($canonical);
        $this->throw404Unless($model);
        $form = $this->createForm(AudiobookType::class, $model);
        $status = $status =  $this->handleForm($request, $form, $model, AudiobookManager::INTENT_UPDATE);
        if( Response::HTTP_ACCEPTED === $status ){
            $this->getManager()->save($model);
            return $this->redirectToRoute('app_api_audiobooks_show', ['canonical' => $model->getCanonical()]);
        }

        return $this->createResponse($request, [
            'form'  => $form->createView(),
            'model' => $model,
        ], $status);
    }

    public function showAction(Request $request)
    {


    }

}