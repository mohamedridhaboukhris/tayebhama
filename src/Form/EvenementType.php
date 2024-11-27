<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use App\Entity\Salle;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre')
        ->add('description')
        ->add('date', DateType::class, [
            'widget' => 'single_text',
            'html5' => true,
            'attr' => [
                'min' => '2024-01-01', // Limite minimale à 2024
            ],
        ])
        ->add('heureDebut', TimeType::class, [
            'widget' => 'single_text',
        ])
        ->add('heureFin', TimeType::class, [
            'widget' => 'single_text',
        ])
        ->add('salle', EntityType::class, [
            'class' => Salle::class,
            'choice_label' => 'code',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
