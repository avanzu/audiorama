<?php
/**
 * AppExtension.php
 * audiorama
 * Date: 13.05.17
 */

namespace AppBundle\Twig;

/**
 * Class AppExtension
 */
class AppExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('speakers_term', [$this, 'getSpeakersTerm']),
            new \Twig_SimpleFilter('authors_term', [$this, 'getAuthorsTerm']),
        ];
    }

    /**
     * @param       $type
     * @param       $term
     * @param array $query
     *
     * @return array
     */
    protected function buildTermQuery($type, $term, $query = [])
    {
        return array_merge($query, ['term' => sprintf('%s:"%s"', $type, (string)$term)]);
    }

    /**
     * @param       $speaker
     * @param array $query
     *
     * @return array
     */
    public function getSpeakersTerm($speaker, $query = [])
    {
        return $this->buildTermQuery('speakers', $speaker, $query);
    }

    /**
     * @param       $speaker
     * @param array $query
     *
     * @return array
     */
    public function getAuthorsTerm($speaker, $query = [])
    {
        return $this->buildTermQuery('authors', $speaker, $query);
    }
}