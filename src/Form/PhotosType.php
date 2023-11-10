<?php

namespace App\Form;

use App\Entity\Photos;
use App\Entity\Tournois;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PhotosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->remove('titre')
            ->remove('description')
            ->add('imageFile', FileType::class, [
                'label' => 'Image Epreuve',
                'required' => true,
                // 'allow_delete' => false,
                // 'download_uri' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '60M',
                        'mimeTypes' => [
                            'video/mp4',
                            'video/avi',
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            // ajoutez ici les types de vidéos que vous souhaitez accepter
                        ],
                        'mimeTypesMessage' => 'Le fichier image doit etre de type jpeg, png, gif et la vidéo doit être de format mp4 et avi d\'un minimum de 60 MO '
                    ])
                ]
            ])

            ->remove('users', UserType::class, [])
            ->add('tournois', EntityType::class, [
                'choice_label' => 'annee',
                'placeholder' => 'Selectionner une année',
                'class' => Tournois::class,
                'expanded' => false,
                'attr' => ['class' => 'custom-select'],


            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photos::class,
        ]);
    }
}
