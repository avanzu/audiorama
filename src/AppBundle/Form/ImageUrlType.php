<?php
/**
 * ImageUrlType.php
 * audiorama
 * Date: 13.05.17
 */

namespace AppBundle\Form;


use AppBundle\Model\ImageUrlProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageUrlType extends AbstractType
{
    /**
     * @var
     */
    protected $placeholder;



    /**
     * ImageUrlType constructor.
     *
     * @param $placeholder
     */
    public function __construct($placeholder) {
        $this->placeholder = $placeholder;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'image_url';
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'placeholder_image' => $this->placeholder
        ]);
    }


    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $url  = $form->getData() ?: $options['placeholder_image'];
        $view->vars['image_url'] = $url;
        $view->vars['is_asset']  = (false === strpos($url, '//'));
    }


}