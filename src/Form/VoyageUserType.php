<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Voyage;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyageUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $user = $options['user'];
        $builder
            ->add('users', EntityType::class, [
                'class' => User::class,
                'label' => 'Users',
                'choice_label' => 'username',
                'placeholder' => 'Sélectionnez un ou plusieurs utilisateurs',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.id != :user')
                        ->setParameter('user', $user->getId())
                        ->orderBy('u.username', 'ASC');
                },
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voyage::class,
            'user' => null,
        ]);
    }
}
