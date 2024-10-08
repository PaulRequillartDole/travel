<?php

namespace App\Form;

use App\Entity\Icon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IconType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label')
        ;

        if (!$builder->getData()->getId()){
            $builder->add('saveAndAdd', SubmitType::class, ['label' => 'Save and Add']);

        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Icon::class,
        ]);
    }
}
