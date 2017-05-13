<?php
/**
 * SpeakerChoiceType.php
 * audiorama
 * Date: 02.05.17
 */

namespace AppBundle\Form;


use AppBundle\Entity\Speaker;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpeakerChoiceType extends AbstractType
{

    public function getParent()
    {
        return EntityType::class;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'class'         => Speaker::class,
           'attr' => array('data-live-search' => true),
           'query_builder' => function (EntityRepository $repository) {
               return $repository
                   ->createQueryBuilder('speaker')
                   ->orderBy('speaker.firstName')
                   ;
           },
       ]);
    }
}