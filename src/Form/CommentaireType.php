<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('auteur', TextType::class, [
                'label' => "Auteur",
                'attr' => [
                    'placeholder' => "Entrer votre nom"
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => "Commentaire",
                'attr' => [
                    'placeholder' => "Entrer ici votre commentaire"
                ]
            ])
            ->add('save', SubmitType::class,[
                'label' => "Ajouter un nouveau commentaire",
                'attr' => [
                    'class' => "btn btn-primary"
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
