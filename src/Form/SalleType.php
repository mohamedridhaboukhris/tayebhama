<?php

namespace App\Form;

use App\Entity\Salle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Code de la Salle'
            ])
            ->add('capacite', IntegerType::class, [
                'label' => 'Capacité'
            ])
            ->add('type', TextType::class, [
                'label' => 'Type'
            ])
            ->add('bloc', ChoiceType::class, [
                'label' => 'Bloc',
                'choices' => [
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                    'E' => 'E',
                    'G' => 'G',
                    'H' => 'H',
                    'I' => 'I',
                    'J' => 'J',
                    'K' => 'K',
                    'M' => 'M',
                ],
                'placeholder' => 'Sélectionnez un bloc',
                'required' => true,
            ])
            ->add('etage', ChoiceType::class, [
                'label' => 'Étage',
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                ],
                'placeholder' => 'Sélectionnez un étage',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Salle::class,
        ]);
    }
}
