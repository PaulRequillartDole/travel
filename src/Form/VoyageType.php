<?php

namespace App\Form;

use App\Entity\Status;
use App\Entity\User;
use App\Entity\Voyage;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('destination')
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('startAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
                'required' => false,
            ])
            ->add('endAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'required' => false,
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'label' => 'Statut',
                'choice_label' => 'label',
                'placeholder' => 'Sélectionnez un statut',
            ])
            ->add('users', EntityType::class, [
                'class' => User::class,
                'label' => 'Users',
                'choice_label' => 'username',
                'placeholder' => 'Sélectionnez un ou plusieurs utilisateurs',
                'multiple' => true,
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
