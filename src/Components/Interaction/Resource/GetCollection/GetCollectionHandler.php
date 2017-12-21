<?php
/**
 * GetCollectionHandler.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Interaction\Resource\GetCollection;


use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Interaction\Resource\ResourceHandler;

class GetCollectionHandler extends ResourceHandler
{

    protected function getResponseClassForRequest(IRequest $request)
    {
        $class = str_replace('Request', 'Response', get_class($request));
        return (class_exists($class)) ? $class : GetCollectionResponse::class;
    }

    /**
     * @param IRequest|GetCollectionRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
    {
        $manager    = $this->getManager();
        try {

            $collection = $manager->getCollectionByCriteria(
                $request->getPage(),
                $request->getLimit(),
                $request->getTerm(),
                $request->getSortBy(),
                $request->getSortDir()
            );

            //$collection = $manager->getCollection($request->getLimit(), $request->getOffset(), $request->getCriteria());
            $class = $this->getResponseClassForRequest($request);
            return new $class($collection, $request, $manager->getSortableFields());

        } catch ( \Exception $e ) {
            return new ErrorResponse(
                sprintf('%s.%s.error', $request->getResourceName(), $request->getIntention()),
                IResponse::STATUS_INTERNAL_SERVER_ERROR,
                $e
            );
        }

    }
}