<?php

namespace App\Form;

use App\Entity\Sports;
use App\Entity\Tournois;
use App\Form\SportsType;
use App\Entity\Participants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TournoisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextareaType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nom de tournoi'
                    ])
                ]
            ])
            ->add('annee', IntegerType::class, [
                'required' => true,
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Trophée Winner',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
            ])
            ->add('imageFile1', VichImageType::class, [
                'label' => 'Photo Winner',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
            ])
            ->add('sports', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Sports::class,
                'multiple' => true, // OBLIGATOIRE POUR LA RELATION MANYTOMANY
                'expanded' => true,

            ])
            ->add('newSports', CollectionType::class, [
                "entry_type" => SportsType::class,
                'label' => false,
                'required' => false,
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'mapped' => false // existe dans le formulaire sans exister dans l'entité
            ])
            ->add('participants', EntityType::class, [
                'choice_label' => 'nom',
                'class' => Participants::class,
                'multiple' => true, // OBLIGATOIRE POUR LA RELATION MANYTOMANY
                'expanded' => true,
            ])
            ->add('newParticipants', CollectionType::class, [
                "entry_type" => ParticipantsType::class,
                'label' => false,
                'required' => false,
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'mapped' => false // existe dans le formulaire sans exister dans l'entité
            ])
            ->add('nbParticipants');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tournois::class,
        ]);
    }
}
