<?php

namespace App\Form;

use App\Entity\Sports;
use App\Entity\Tournois;
use App\Entity\Trophees;
use App\Entity\Participants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TropheesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('tournois', EntityType::class, [
                'choice_label' => 'annee',
                'class' => Tournois::class,
                'multiple' => false, // OBLIGATOIRE POUR LA RELATION MANYTOMANY
                'expanded' => true,
            ])
            ->add('participants', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Participants::class,
                'multiple' => true, // OBLIGATOIRE POUR LA RELATION MANYTOMANY
                'expanded' => true,
            ])
            ->add('sports', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Sports::class,
                'multiple' => false, // OBLIGATOIRE POUR LA RELATION MANYTOMANY
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trophees::class,
        ]);
    }
}
