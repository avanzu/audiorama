<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DashboardController
 */
class DashboardController extends Controller
{
    /**
     * @param Request $request
     *
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        if( $response = $this->forwardIfTerm($request)) {
            return $response;
        }



        return $this->render('@App/Dashboard/index.html.twig', [
            'stats' => $this->get('app.manager.stats')->getPublicStats()
        ]);
    }

    /**
     * @param Request $request
     *
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function forwardIfTerm(Request $request)
    {
        if( $request->query->has('term') ) {
            return $this->redirectToRoute('app_audiobooks_index', $request->query->all());
        }

        return false;
    }
}
