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

