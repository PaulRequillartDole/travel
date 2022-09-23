<?php

namespace App\Form;

use App\Entity\Icon;
use App\Entity\Section;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('icon', EntityType::class, [
                'class' => Icon::class,
                'choice_label' => 'label',
                'expanded' => true,
                'required' => false,
                'placeholder' => 'Aucune icône',
                'label' => 'Icône',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Section::class,
        ]);
    }
}
