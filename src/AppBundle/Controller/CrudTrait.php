<?php
/**
 * CrudTrait.php
 * audiorama
 * Date: 14.05.17
 */

namespace AppBundle\Controller;


use AppBundle\Manager\AudiobookManager;
use AppBundle\Manager\ResourceManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CrudTrait
 * @method ResourceManager getManager
 * @method Form createForm($type, $model)
 */
trait CrudTrait
{

    public function createAction(Request $request)
    {
        $model  = $this->getManager()->createNew();
        $form   = $this->createForm($this->getFormType(), $model);
        $status =  $this->handleForm($request, $form, $model, AudiobookManager::INTENT_CREATE);

        if(Response::HTTP_ACCEPTED === $status ){
            $this->getManager()->save($model);
            $status = Response::HTTP_CREATED;
            if( $response = $this->getRedirectFromRequest($request, $model)) {
                return $response;
            }
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
        $form = $this->createForm($this->getFormType(), $model);
        $status = $status =  $this->handleForm($request, $form, $model, AudiobookManager::INTENT_UPDATE);
        if( Response::HTTP_ACCEPTED === $status ){
            $this->getManager()->save($model);
            $status = Response::HTTP_OK;
            if( $response = $this->getRedirectFromRequest($request, $model)) {
                return $response;
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