<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCours', TextType::class, [
                'label' => 'Nom du Cours',
                'attr' => [
                    'placeholder' => 'Entrez le nom du cours',
                ],
            ])
            ->add('enseignantResponsable', TextType::class, [
                'label' => 'Enseignant Responsable',
                'attr' => [
                    'placeholder' => 'Nom de l\'enseignant',
                ],
            ])
            ->add('classConcernee', TextType::class, [
                'label' => 'Classe Concernée',
                'attr' => [
                    'placeholder' => 'Exemple : Niveau 3',
                ],
            ])
            ->add('horaires', DateType::class, [
                'label' => 'Horaires',
                'widget' => 'single_text', // Affiche un champ de date unique (format ISO)
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Détails du cours',
                ],
            ])
            ->add('dateCreation', DateType::class, [
                'label' => 'Date de Création',
                'widget' => 'single_text',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
