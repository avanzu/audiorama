<?php
/**
 * CreateSpeakerRequestType.php
 * audiorama
 * Date: 09.11.17
 */

namespace AppBundle\Form;


use Components\Interaction\Speakers\CreateSpeaker\CreateSpeakerRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateSpeakerRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dao', SpeakerType::class, ['label' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(
                [
                    'data_class' => CreateSpeakerRequest::class,
                    'label'      => false,
                ]
            );
    }


}