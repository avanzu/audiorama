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
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * AppExtension constructor.
     *
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig) {
        $this->twig = $twig;
    }


    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('speakers_term', [$this, 'getSpeakersTerm']),
            new \Twig_SimpleFilter('authors_term', [$this, 'getAuthorsTerm']),
            new \Twig_SimpleFilter('genres_term', [$this, 'getGenresTerm']),
            new \Twig_SimpleFilter('series_term', [$this, 'getSeriesTerm']),
            new \Twig_SimpleFilter('truncate', [$this, 'truncate']),
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('uid', [$this, 'getUniqueId']),
            new \Twig_SimpleFunction('widget', [$this, 'renderWidget'], ['is_safe' => ['html']])
        ];
    }

    public function getUniqueId($prefix, $length = 6)
    {
        $random = mt_rand(0, (1 << ($length << 2)) - 1);
        return $prefix . dechex($random);
    }


    /**
     * @param        $string
     * @param        $length
     * @param string $ellipsis
     *
     * @return string
     */
    public function truncate($string, $length, $ellipsis = ' [...]')
    {
        if( strlen($string) < $length)
            return $string;

        return substr($string, 0, strpos(wordwrap($string, $length), PHP_EOL, $length)) . $ellipsis;
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

    /**
     * @param       $series
     * @param array $query
     *
     * @return array
     */
    public function getSeriesTerm($series, $query = [])
    {
        return $this->buildTermQuery('series', $series, $query);
    }

    /**
     * @param       $genre
     * @param array $query
     *
     * @return array
     */
    public function getGenresTerm($genre, $query = [])
    {
        return $this->buildTermQuery('genre', $genre, $query);
    }

    /**
     * @param       $name
     * @param array $args
     *
     * @return string
     */
    public function renderWidget($name, $args = [])
    {
        $template = $this->twig->loadTemplate('@App/Partials/widgets.html.twig');
        return $template->renderBlock($name, $this->twig->mergeGlobals($args));
    }
}