<?php
/**
 * ResourceController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;


use AppBundle\Manager\ResourceManager;
use Components\Infrastructure\Controller\ICommandRunner;
use Components\Infrastructure\Presentation\IPresenter;
use Components\Infrastructure\Presentation\TemplateView;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ContinueCommandResponse;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\IResponse;
use Components\Interaction\Resource\GetCollection\GetCollectionRequest;
use Components\Localization\ILocalizer;
use Components\Resource\IManager;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResourceController
 */
class ResourceController extends Controller implements ICommandRunner, IPresenter
{
    use CrudTrait;

    /**
     * @var IManager
     */
    protected $manager;
    /**
     * @var IPresenter
     */
    protected $presenter;
    /**
     * @var ViewHandlerInterface
     */
    protected $viewHandler;
    /**
     * @var ILocalizer
     */
    private $localizer;

    /**
     * ResourceController constructor.
     *
     * @param ResourceManager      $manager
     * @param IPresenter           $presenter
     * @param ILocalizer           $localizer
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(
        ResourceManager $manager,
        IPresenter $presenter,
        ILocalizer $localizer,
        ViewHandlerInterface $viewHandler
    ) {
        $this->manager     = $manager;
        $this->viewHandler = $viewHandler;
        $this->presenter   = $presenter;
        $this->localizer   = $localizer;
    }

    /**
     * @param         $resource
     * @param Request $request
     *
     * @return Response
     */
    public function getCollectionAction($resource, Request $request)
    {
        $command = new GetCollectionRequest(
            null,
            $resource,
            $request->get('limit', 10),
            $request->get('offset')
        );

        $result = $this->executeCommand($command);

        return new Response($this->get('serializer')->serialize($result, 'json'));

    }

    /**
     * @param IRequest $request
     *
     * @return IResponse|ErrorResponse|\Exception
     */
    public function executeCommand(IRequest $request)
    {
        try {
            return $this->get('app.command_bus')->execute($request);
        } catch (ErrorResponse $error) {
            return $error;
        }
    }

    /**
     * @param TemplateView $view
     *
     * @return string
     */
    public function show(TemplateView $view)
    {
        return $this->getPresenter()->show($view);
    }

    protected function getFormType()
    {
        return FormType::class;
    }

    /**
     * @return IManager
     */
    protected function getManager()
    {
        return $this->manager;
    }

    /**
     * @param TemplateView $view
     *
     * @return Response
     */
    protected function createResponseFromView(TemplateView $view)
    {
        return new Response($this->getPresenter()->show($view));
    }

    /**
     * @return IPresenter
     */
    public function getPresenter()
    {
        return $this->presenter;
    }

    /**
     * @param        $condition
     * @param string $message
     *
     * @return mixed
     */
    protected function throw404Unless($condition, $message = 'Not Found')
    {
        if (!$condition) {
            throw $this->createNotFoundException($message);
        }

        return $condition;
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

        if (!$form->isSubmitted()) {
            return Response::HTTP_OK;
        }

        if (!$form->isValid()) {
            return Response::HTTP_BAD_REQUEST;
        }

        return Response::HTTP_ACCEPTED;
    }

    /**
     * @param Request $request
     *
     * @param array   $data
     * @param int     $httpStatus
     * @param array   $headers
     *
     * @return Response
     */
    protected function createResponse($request, $data = [], $httpStatus = Response::HTTP_OK)
    {
        if( $request instanceof TemplateView ) {
            return $this->createResponseFromView($request);
        }

        $view = View::create($data)
                    ->setFormat($this->getResponseFormat($request))
        ;
        if ($this instanceof TemplateAware) {
            $view->setTemplate($this->getTemplate());
        }

        return $this->viewHandler->handle($view)->setStatusCode($httpStatus);
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    protected function getResponseFormat(Request $request)
    {
        $formats = array_map(
            function ($list) {
                $_ = explode('/', $list);

                return end($_);
            },
            $request->getAcceptableContentTypes()
        );

        if ($format = $request->get('_format')) {
            array_unshift($formats, $format);
        }

        foreach ($formats as $format) {
            if ($this->viewHandler->supports($format)) {
                return $format;
            }
        }

        return 'html';
    }

    /**
     * @param Request $request
     * @param         $model
     *
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function getRedirectFromRequest(Request $request, $model)
    {
        if ($route = $request->get('_redirect')) {
            return $this->redirectToRoute($route, ['canonical' => $model->getCanonical()]);
        }

        return false;
    }

    /**
     * @param         $model
     * @param Request $request
     * @param null    $intent
     */
    protected function preSaveModel($model, Request $request, $intent = null)
    {
    }

    /**
     * @param         $model
     * @param Request $request
     * @param null    $intent
     */
    protected function postSaveModel($model, Request $request, $intent = null)
    {
    }

    /**
     * @param Form             $form
     * @param IRequest|Request $request
     * @param IRequest         $command
     *
     * @return IResponse
     */
    protected function getInteractionResponse(Form $form, Request $request, IRequest $command)
    {
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return new ContinueCommandResponse();
        }

        return $this->executeCommand($form->getData());

    }
}