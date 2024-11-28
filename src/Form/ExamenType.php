<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Examen;
use App\Entity\Professor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ExamenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Exam Name',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'The exam name cannot be empty.',
                    ]),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'The exam name cannot exceed {{ limit }} characters.',
                    ]),
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'The exam date cannot be empty.',
                    ]),
                    new Assert\Type([
                        'type' => \DateTime::class,
                        'message' => 'The value {{ value }} is not a valid date.',
                    ]),
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Duration (minutes)',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'The exam duration cannot be empty.',
                    ]),
                    new Assert\Positive([
                        'message' => 'The duration must be a positive number.',
                    ]),
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('location', TextType::class, [
                'label' => 'Location',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'The location cannot be empty.',
                    ]),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'The location cannot exceed {{ limit }} characters.',
                    ]),
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'DS' => 'DS',
                    'Examen' => 'Examen',
                    'Pratique' => 'Pratique',
                    'Théorique' => 'Théorique',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'The exam type cannot be empty.',
                    ]),
                    new Assert\Choice([
                        'choices' => ['DS', 'Examen', 'Pratique', 'Théorique'],
                        'message' => 'Choose a valid exam type.',
                    ]),
                ],
                'placeholder' => 'Select a type',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('professeurDeGarde', EntityType::class, [
                'class' => Professor::class,
                'choice_label' => 'name',
                'label' => 'Professor on Duty',
                'constraints' => [
                    new Assert\NotNull([
                        'message' => 'The professor on duty must be selected.',
                    ]),
                ],
                'placeholder' => 'Select a professor',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('classes', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'label' => 'Classes Concerned',
                'constraints' => [
                    new Assert\Count([
                        'min' => 1,
                        'minMessage' => 'You must select at least one class.',
                    ]),
                ],
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Examen::class,
        ]);
    }
}
