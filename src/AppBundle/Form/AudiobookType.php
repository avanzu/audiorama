<?php
/**
 * AudiobookType.php
 * audiorama
 * Date: 02.05.17
 */

namespace AppBundle\Form;


use AppBundle\Entity\Audiobook;
use AppBundle\Entity\Author;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AudiobookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [

            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'rows' => 15
                ]
            ])
            ->add('coverImage', ImageUrlType::class, [

            ])
            ->add('storageType', TextType::class, [

            ])
            ->add('authors', AuthorChoiceType::class, [
                'multiple' => true
            ])
            ->add('speakers', SpeakerChoiceType::class, [
                'multiple' => true
            ])
            ->add('genre', GenreChoiceType::class, [

            ])
            ->add('series', SeriesChoiceType::class, [

            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Audiobook::class
        ]);
    }


}