<?php

namespace App\Form;

use App\Entity\Tournois;
use App\Entity\Positions;
use App\Entity\Participants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PositionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('positions')
            ->add('tournois', EntityType::class, [
                'choice_label' => 'annee',
                'class' => Tournois::class,
                'expanded' => true,
            ])
            ->add('participants', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Participants::class,
                'multiple' => false, // OBLIGATOIRE POUR LA RELATION MANYTOMANY
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Positions::class,
        ]);
    }
}
