<?php

namespace App\Form;

use App\Entity\Sports;
use App\Entity\Tournois;
use App\Form\SportsType;
use App\Entity\Classement;
use App\Entity\Participants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ClassementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('points', ChoiceType::class, [
                'choices' => array_combine(range(0, 100), range(0, 100)),
                'label' => 'Quantité de points',
                'placeholder' => 'Selectionner une quantité',

            ])
            ->add('participants', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Participants::class,
                'multiple' => false, // OBLIGATOIRE POUR LA RELATION MANYTOMANY
                
                
            ])
            ->add('sports', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Sports::class,
                'multiple' => false, // OBLIGATOIRE POUR LA RELATION MANYTOMANY
                'expanded' => false,
                
            ])
            // ->add('sports', CollectionType::class, [
            //     "entry_type" => SportsType::class,
            //     "allow_add"=> true, // permet de rajouter une nouvelle question autant de fois que l'on veut
            //     "allow_delete"=>true,
            //     "by_reference"=>false, // si ca ne marche pas il faut mettre ce truc sans por autant que la doc nous en dise plus
            //     "label" =>false,
                
                
                
            // ])
            ->add('tournois', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Tournois::class,
                'multiple' => false, // OBLIGATOIRE POUR LA RELATION MANYTOMANY
                'expanded' => true,
                
            ])
            ->add('positions')
            ;

            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classement::class,
        ]);
    }
}
