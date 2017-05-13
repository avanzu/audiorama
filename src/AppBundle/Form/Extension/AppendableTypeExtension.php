<?php
/**
 * AppendableChoiceType.php
 * audiorama
 * Date: 13.05.17
 */

namespace AppBundle\Form\Extension;


use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppendableTypeExtension extends AbstractTypeExtension
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'appendable'      => false,
            'add_item_route'  => null,
            'add_item_params' => []
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {

        $view->vars['appendable']      = $options['appendable'];
        $view->vars['add_item_route']  = $options['add_item_route'];
        $view->vars['add_item_params'] = $options['add_item_params'];
    }


    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return FormType::class;
    }
}