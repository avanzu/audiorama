<?php
/**
 * KernelControllerSubscriber.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\EventListener;


use AppBundle\Controller\TemplateAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelControllerSubscriber implements EventSubscriberInterface
{

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        if (!is_array($controller)) {
            return;
        }

        $object = reset($controller);

        $this->configureTemplate($object, $event->getRequest());

    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        // Do not save subrequests
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }

        $request     = $event->getRequest();
        $session     = $request->getSession();
        $routeName   = $request->get('_route');
        $uri         = $request->getRequestUri();

        if ($routeName[0] == '_') {
            return;
        }

        // Do not save same matched route twice
        $thisRoute = $session->get('_this_route', '');
        if ($thisRoute == $uri) {
            return;
        }

        $session->set('_last_route', $thisRoute);
        $session->set('_this_route', $uri);

        return;
    }

    /**
     * @param $controller
     * @param $request
     */
    protected function configureTemplate($controller, $request)
    {
        if( ! $controller instanceof TemplateAware ) {
            return;
        }

        if( $request->attributes->has('_template') ) {
            $controller->setTemplate($request->attributes->get('_template'));
        }
    }

    /** @inheritdoc */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::REQUEST    => 'onKernelRequest'
        ];
    }


}