<?php
/**
 * CreateResourceHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource\DeleteResource;

use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\ValidationFailedResponse;
use Components\Interaction\Resource\ResourceHandler;

/**
 * Class DeleteResourceHandler
 */
class DeleteResourceHandler extends ResourceHandler
{

    /**
     * @param DeleteResourceRequest|IRequest $request
     *
     * @return DeleteResourceResponse|ErrorResponse
     */
    public function handle(IRequest $request)
    {
        $resource = $request->getDao();
        $result   = $this->manager->validate($resource, ["Default", $request->getIntention()]);
        if (!$result->isValid()) {
            return new ValidationFailedResponse($result);
        }

        try {
            $this->manager->remove($resource);
        } catch (\Exception $reason) {
            return new ErrorResponse('Unable to delete resource', 1, $reason);
        }

        return $this->createResponse($request, $resource);
    }

    /**
     * @param IRequest       $request
     * @param                $resource
     *
     * @return DeleteResourceResponse
     */
    protected function createResponse(IRequest $request, $resource)
    {
        $responseClass = str_replace('Request', 'Response', get_class($request));
        if (class_exists($responseClass)) {
            return new $responseClass($resource, $request);
        }

        return new DeleteResourceResponse($resource, $request);
    }
}