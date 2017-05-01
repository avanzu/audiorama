<?php
/**
 * MaterializeView.php
 * audiorama
 * Date: 29.04.17
 */

namespace AppBundle\Pagination;


use AppBundle\Pagination\Template\MaterializeTemplate;
use Pagerfanta\View\DefaultView;

class MaterializeView extends DefaultView
{
    protected function createDefaultTemplate()
    {
        return new MaterializeTemplate();
    }

    protected function getDefaultProximity()
    {
        return 3;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'materialize';
    }
}