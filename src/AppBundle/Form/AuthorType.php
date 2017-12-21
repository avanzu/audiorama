<?php
/**
 * AuthorType.php
 * audiorama
 * Date: 14.05.17
 */

namespace AppBundle\Form;


use AppBundle\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                /** @Desc("First name") */
                'label' => 'label.author.first_name',
            ])
            ->add('lastName', TextType::class, [
                /** @Desc("Last name") */
                'label' => 'label.author.last_name',
            ])
            ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([ 'data_class' => Author::class] );
    }

}