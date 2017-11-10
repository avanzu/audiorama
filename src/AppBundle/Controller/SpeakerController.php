<?php
/**
 * SpeakerController.php
 * audiorama
 * Date: 14.05.17
 */

namespace AppBundle\Controller;


use AppBundle\Form\GetCollectionRequestType;
use AppBundle\Form\SpeakerType;
use AppBundle\Traits\Flasher;
use Components\Interaction\Speakers\GetCollection\GetSpeakersRequest;
use Components\Interaction\Speakers\GetCollection\GetSpeakersResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SpeakerController
 */
class SpeakerController extends PersonController implements IFlashing
{
    use Flasher;

    /**
     * @return string
     */
    protected function getFormType()
    {
        return SpeakerType::class;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $command = new GetSpeakersRequest($request->query->all());
        $form    = $this->createForm(GetCollectionRequestType::class, $command);

        $form->handleRequest($request);

        /** @var GetSpeakersResponse $result */
        $result = $this->executeCommand($command);

        return $this->createResponse(
            $request,
            [
                'result'   => $result->getResource(),
                'query'    => $command->getQuery(),
                'sorted'   => $command->getSortBy(),
                'sortable' => $result->getSortable(),
            ]
        );
    }


}