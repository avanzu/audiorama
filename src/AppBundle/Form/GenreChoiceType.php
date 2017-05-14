<?php
/**
 * GenreChoiceType.php
 * audiorama
 * Date: 02.05.17
 */

namespace AppBundle\Form;


use AppBundle\Entity\Genre;
use AppBundle\Repository\AttributeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenreChoiceType extends AbstractType
{
    public function getParent()
    {
        return EntityType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'appendable' => true,
            'add_item_route' => 'app_genres_append',
            'class'         => Genre::class,
            'required'      => false,
            'empty_data'    => null,
            'placeholder'   => 'placeholder.choose_genre',
            'query_builder' => function (AttributeRepository $repository) {
                return $repository->getChoiceBuilder();
            },
        ]);
    }


}