<?php

namespace App\Form;



use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Ville;
use App\Entity\Sortie;



use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',)
            ->add('dateHeureDebut')
            ->add('duree')
            ->add('dateLimiteInscription')
            ->add('nbInscriptionMax')
            ->add('infosSortie');


        $builder->add('dateHeureDebut', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd']);

        $builder->add('dateLimiteInscription', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd']);


        $builder ->add('ville', EntityType::class,[

                    'class' => 'App\Entity\Ville',

                    'mapped' => false,

                    'choice_label' => 'nom_ville',

                    'placeholder' => 'Selectionner une ville',

                    'required' => true

                ]

            );
        $builder ->add('lieu', EntityType::class,[

                'class' => 'App\Entity\Lieu',

                'mapped' => false,

                'choice_label' => 'nom',

                'placeholder' => 'Selectionner un lieu',

                'required' => true

            ]

        );
















    }



    private function addLieuField(FormInterface $form, ?Ville $ville){

        $builder = $form->add('LieuxNoLieux', EntityType::class,[

            'class' => Lieu::class,

            'choice_label' => 'nom',

            'placeholder' => $ville ? 'Selectionnez votre lieu' : 'Selectionnez votre ville',

            'required' => true,

            'auto_initialize' => false,

            'choices' => $ville ? $ville->getLieu() : []

        ]);
        $builder->add('id', EntityType::class, [
           'required' => true,
            'label' => 'Choisir une lieux',
            'class' => Lieu::class,
           'choice_label' => 'rue',

        ]);



        $builder->add('submit', SubmitType::class, [
            'label' => 'Publier la sortie'
        ]);

    }



















    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}

