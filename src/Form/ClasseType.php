<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la Classe',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nom de la classe'
                ]
            ])
            ->add('niveau', TextType::class, [
                'label' => 'Niveau',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le niveau (ex: 6e, 5e)'
                ]
            ])
            ->add('annee', ChoiceType::class, [
                'label' => 'Année',
                'choices' => array_combine(range(2011, 2030), range(2011, 2030)),
                'attr' => [
                    'class' => 'form-select',
                ],
                'placeholder' => 'Sélectionnez une année',
            ])
            
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'nom',
                'label' => 'Spécialité',
                'placeholder' => 'Sélectionnez une spécialité',
                'attr' => [
                    'class' => 'form-select'
                ]
            ])


            ->add('nombreEtudiants', IntegerType::class, [
                'label' => 'Nombre d\'Étudiants',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entre 25 et 32',
                    'min' => 25,
                    'max' => 32
                ]
            ])

            
            ->add('status', ChoiceType::class, [
                'label' => 'État de la classe',
                'choices' => [
                    'En cours' => 'cours',
                    'En pause' => 'pause',
                    'Fin de journée' => 'fin',
                ],
                'data' => $options['data']->getStatus() ?? 'cours', // Valeur par défaut si status est null
                'required' => false,
                'attr' => [
                    'style' => 'display:none;', // Si vous souhaitez masquer ce champ
                ],
            ])      
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classe::class,
        ]);
    }
}
