<?php
// src/Form/OuvrageType.php
namespace App\Form;

use App\Entity\Ouvrage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OuvrageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('auteur')
            ->add('editeur')
            ->add('isbn')
            ->add('langue')
            ->add('annee')
            ->add('resume')
            ->add('categories', ChoiceType::class, [
                'choices' => [
                    'Roman' => 'Roman',
                    'Jeunesse' => 'Jeunesse',
                    'Science' => 'Science',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('tags', ChoiceType::class, [
                'choices' => [
                    'Classique' => 'Classique',
                    'Aventure' => 'Aventure',
                    'Fantastique' => 'Fantastique',
                ],
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ouvrage::class,
        ]);
    }
}
