<?php

namespace App\Form;

use App\Entity\Sports;
use App\Entity\Tournois;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SportsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->remove('tournois', EntityType::class, [
                'choice_label' => 'annee',
                'class' => Tournois::class,
                'multiple' => true, // OBLIGATOIRE POUR LA RELATION MANYTOMANY
                'expanded' => true,
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Photo Epreuve',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
            ])
            ->add('imageFile1', VichImageType::class, [
                'label' => 'Icone Thophee',
                'required' => false,
                // 'allow_delete' => false,
                // 'download_uri' => false,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sports::class,
        ]);
    }
}
