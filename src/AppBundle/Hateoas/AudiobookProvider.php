<?php
/**
 * AudiobookProvider.php
 * audiorama
 * Date: 01.05.17
 */

namespace AppBundle\Hateoas;


use AppBundle\Entity\Audiobook;
use Symfony\Component\HttpFoundation\Request;

class AudiobookProvider extends AbstractProvider
{

    /**
     * @param Audiobook $object
     *
     * @return array
     */
    public function decorate($object, Request $request = null)
    {
        return [
            '_self' => $this->getUrl('app_audiobooks_show', ['canonical' => $object->getCanonical()])
        ];
    }

    /**
     * @param $object
     *
     * @return bool
     */
    public function isSupported($object)
    {
        return ($object instanceof Audiobook);
    }
}