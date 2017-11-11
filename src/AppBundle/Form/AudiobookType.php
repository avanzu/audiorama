<?php
/**
 * AudiobookType.php
 * audiorama
 * Date: 02.05.17
 */

namespace AppBundle\Form;


use AppBundle\Entity\Audiobook;
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
                /** @Desc("Title") */
                'label' => 'label.audiobook.title'
            ])
            ->add('description', TextareaType::class, [
                /** @Desc("Description") */
                'label' => 'label.audiobook.description',
                'attr' => [
                    'rows' => 15
                ]
            ])
            ->add('coverImage', ImageUrlType::class, [
                /** @Desc("Cover image") */
                'label' => 'label.audiobook.cover_image',
            ])
            ->add('storageType', TextType::class, [
                /** @Desc("Storage type") */
                'label' => 'label.audiobook.storage_type',
            ])
            ->add('authors', AuthorChoiceType::class, [
                /** @Desc("Authors") */
                'label' => 'label.audiobook.authors',
                'multiple' => true
            ])
            ->add('speakers', SpeakerChoiceType::class, [
                /** @Desc("Speakers") */
                'label' => 'label.audiobook.speakers',
                'multiple' => true
            ])
            ->add('genre', GenreChoiceType::class, [
                /** @Desc("Genre") */
                'label' => 'label.audiobook.genre',
            ])
            ->add('series', SeriesChoiceType::class, [
                /** @Desc("Series") */
                'label' => 'label.audiobook.series',
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