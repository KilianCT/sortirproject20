<?php

namespace App\Form;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($options['type'] === 'create' || $options['type'] === 'edit') {
        $builder
            ->add('email')
            ->add('pseudo')
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('site', entityType::class,[

                    'class' => 'App\Entity\Site',

                    'mapped' => false,

                    'choice_label' => 'nom_site',

                    'placeholder' => 'Selectionner une ville',

                    'required' => false

            ]);


            $builder->add('photoUrl', FileType::class, [

                'label' => 'Photo (PNG, JPG, BMP)',

                'mapped' => false,

                'required' => false,

                'constraints' => [

                    new File([

                        'maxSize' => '1024k',

                        'mimeTypes' => [

                            'image/*'

                        ],

                        'mimeTypesMessage' => 'Merci de sélectionner un fichier image.',

                    ])

                ],

            ]);

        }

            if($options['type'] === 'create' || $options['type'] === 'passwordEdit') {
          $builder->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => false,
            'invalid_message' => 'Les mots de passe ne sont pas identique !',
            'options' => ['attr' => ['class' => 'password-field']],
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Mot de passe (Confirmation)'],

          ]);



            }
          if($options['type'] === 'passwordEdit') {
              $builder->add('passwordEdit', PasswordType::class, [
                'label'=> ' nouveau mot de passe'
              ]);
          }







    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
            'type' => 'create',
        ]);
    }
}
