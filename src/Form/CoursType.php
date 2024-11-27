<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
<<<<<<< HEAD
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
=======
>>>>>>> origin/travailtayeb
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCours')
<<<<<<< HEAD
            ->add('EnseignantResponsable')
            ->add('classConcernee')
            ->add('horaires', null, [
                'widget' => 'single_text',
            ])
            ->add('save', SubmitType::class)
=======
            ->add('enseignantResponsable')
            ->add('classConcernee')
            ->add('description')
            ->add('dateCreation', null, [
                'widget' => 'single_text'
            ])
>>>>>>> origin/travailtayeb
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
