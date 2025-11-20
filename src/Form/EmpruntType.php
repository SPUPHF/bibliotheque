<?php

namespace App\Form;

use App\Entity\Emprunt;
use App\Entity\User;
use App\Entity\Exemplaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email', // ou 'username'
            ])
            ->add('exemplaire', EntityType::class, [
                'class' => Exemplaire::class,
                'choice_label' => 'cote',
            ])
            ->add('dateEmprunt', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateRetourPrevu', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateDuRetour', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('penalite', null, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
