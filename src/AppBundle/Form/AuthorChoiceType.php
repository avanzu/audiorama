<?php
/**
 * AuthorChoiceType.php
 * audiorama
 * Date: 02.05.17
 */

namespace AppBundle\Form;


use AppBundle\Entity\Author;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorChoiceType extends AbstractType
{

    public function getParent()
    {
        return EntityType::class;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'class'          => Author::class,
           'attr'           => array('data-live-search' => true),
           'query_builder'  => function (EntityRepository $repository) {
               return $repository
                   ->createQueryBuilder('author')
                   ->orderBy('author.firstName')
                   ;
           },
        ]);
    }


}