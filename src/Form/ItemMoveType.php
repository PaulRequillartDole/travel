<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Section;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemMoveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $voyage = $builder->getData()->getSection()->getVoyage();
        $builder
            ->add('section', EntityType::class, [
                'class' => Section::class,
                'choice_label' => 'title',
                'query_builder' => function (EntityRepository $er) use ($voyage){
                    return $er->createQueryBuilder('s')
                        ->andWhere('s.voyage = :voyage')
                        ->setParameter('voyage', $voyage)
                    ;
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
