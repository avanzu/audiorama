<?php
/**
 * ResourceController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;


use AppBundle\Manager\ResourceManager;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class ResourceController extends Controller
{

    /**
     * @var ResourceManager
     */
    protected $manager;

    protected $viewHandler;

    /**
     * ResourceController constructor.
     *
     * @param ResourceManager      $manager
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(ResourceManager $manager, ViewHandlerInterface $viewHandler) {
        $this->manager     = $manager;
        $this->viewHandler = $viewHandler;
    }

    /**
     * @return ResourceManager
     */
    protected function getManager()
    {
        return $this->manager;
    }

    /**
     * @param        $condition
     * @param string $message
     *
     * @return mixed
     */
    protected function throw404Unless($condition, $message = 'Not Found')
    {
        if( ! $condition ) {
            throw $this->createNotFoundException($message);
        }

        return $condition;
    }


    /**
     * @param         $model
     * @param Request $request
     * @param         $intent
     */
    protected function saveModel($model, Request $request, $intent)
    {
        $this->preSaveModel($model, $request, $intent);
        $this->getManager()->save($model, true, $intent);
        $this->postSaveModel($model, $request, $intent);
    }

    /**
     * @param Request $request
     * @param Form    $form
     * @param         $model
     * @param null    $intent
     *
     * @return bool
     */
    protected function handleForm(Request $request, Form $form, $model = null, $intent = null)
    {
        $form->handleRequest($request);

        if( ! $form->isSubmitted() ) {
            return false;
        }

        if( ! $form->isValid() ) {
            return false;
        }

        return true;
    }

    /**
     * @param         $data
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function createResponse(Request $request, $data = [] )
    {
        $view = View::create($data)
                    ->setFormat($this->getResponseFormat($request))
            ;
        if( $this instanceof TemplateAware ) {
            $view->setTemplate($this->getTemplate());
        }

        return $this->viewHandler->handle($view);

    }

    /**
     * @param Request $request
     *
     * @return string
     */
    protected function getResponseFormat(Request $request)
    {
        $formats = array_map(function($list){
            $_ = explode('/', $list);
            return end($_);
        }, $request->getAcceptableContentTypes());

        if( $format  = $request->get('_format') ){
            array_unshift($formats, $format);
        }

        foreach($formats as $format) {
            if( $this->viewHandler->supports($format)) {
                return $format;
            }
        }

        return 'html';
    }


    /**
     * @param         $model
     * @param Request $request
     * @param null    $intent
     */
    protected function preSaveModel($model, Request $request, $intent = null)
    {}

    /**
     * @param         $model
     * @param Request $request
     * @param null    $intent
     */
    protected function postSaveModel($model, Request $request, $intent = null)
    {}

    /**
     * Translator shorthand method
     *
     * @param        $token
     * @param array  $args
     * @param string $catalog
     *
     * @return string
     */
    protected function trans($token, $args = [], $catalog = 'messages')
    {
        return $this->get('translator')->trans($token, $args, $catalog);
    }

    /**
     * Translator shorthand method
     *
     * @param        $token
     * @param        $num
     * @param        $args
     * @param string $catalog
     *
     * @return string
     */
    protected function transChoice($token, $num, $args, $catalog = 'messages')
    {
        return $this->get('translator')->transChoice($token, $num, $args, $catalog);
    }

}