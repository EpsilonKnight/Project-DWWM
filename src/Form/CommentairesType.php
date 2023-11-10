<?php

namespace App\Form;

use App\Entity\Commentaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('message', TextareaType::class, [
            'label' => false,
            'attr' => [
                'rows' => 3,
                'placeholder' => 'Ecrivez votre sensas, pas plus de 150 caractères',
                
            ],
            
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un message'
                ]),
                new Length([
                    'max' => 150,
                    'maxMessage' => 'Pas plus de 150 caractères'
                ])
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
