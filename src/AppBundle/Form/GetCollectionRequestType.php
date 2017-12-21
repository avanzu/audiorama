<?php
/**
 * GetCollectionRequestType.php
 * audiorama
 * Date: 09.11.17
 */

namespace AppBundle\Form;


use Components\Interaction\Resource\GetCollection\GetCollectionRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetCollectionRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('page', IntegerType::class)
            ->add('limit', IntegerType::class)
            ->add('term', TextType::class)
            ->add('sortBy', TextType::class)
            ->add('sortDir', ChoiceType::class, ['choices' => ['ASC' => 'ASC', 'DESC' => 'DESC']])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'      => GetCollectionRequest::class,
                'csrf_protection' => false,
                'method'          => 'GET',
            ]
        );
    }


}