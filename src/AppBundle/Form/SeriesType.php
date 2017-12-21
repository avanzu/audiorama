<?php
/**
 * SeriesType.php
 * audiorama
 * Date: 14.05.17
 */

namespace AppBundle\Form;


use AppBundle\Entity\Series;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                /** @Desc("Name") */
                'label' => 'label.series.name',
            ])
            ->add('description', TextareaType::class, [
                /** @Desc("Description") */
                'label' => 'label.series.description',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Series::class]);
    }


}