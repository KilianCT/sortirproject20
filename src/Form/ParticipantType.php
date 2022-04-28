<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('pseudo')
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('photo_url')
            ->add('site_no_site', ChoiceType::class, [
                'choices'=> [
                    'Nantes' => true,
                    'Angers' => false,
                    ]

            ]);

          $builder->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => true,
            'invalid_message' => 'Les mots de passe ne sont pas identique !',
            'options' => ['attr' => ['class' => 'password-field']],
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Mot de passe (Confirmation)'],
        ]);

            $builder->add('submit', SubmitType::class, [


                'label' =>  $options['type'] === 'create' ? 'Créer' : 'Modifier',
            ]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
            'type' => 'create',
        ]);
    }
}
