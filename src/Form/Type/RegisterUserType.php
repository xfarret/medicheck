<?php

namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterUserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('firstname', TextType::class, [
                'label'                 => 'register.firstname',
                'required'              => true,
                'translation_domain'    => 'register'
            ])
            ->add('lastname', TextType::class, [
                'label'                 => 'register.lastname',
                'required'              => true,
                'translation_domain'    => 'register'
            ])
            ->add('numsecu', TextType::class, [
                'label'                 => 'register.numsecu',
                'required'              => true,
                'translation_domain'    => 'register'
            ])
            ->add('passwordUnencoded', RepeatedType::class, [
                'type'                  => PasswordType::class,
                'invalid_message'       => 'register.error.password',
                'required'              => false,
                'translation_domain'    => 'register',
                'first_options'         => array(
                    'label'                     => 'register.password.first',
                    'error_bubbling'            => true
                ),
                'second_options'        => array(
                    'label'                     => 'register.password.second',
                    'error_bubbling'            => true
                ),

            ])
            ->add('email', EmailType::class, [
                'label'                 => 'register.email',
                'required'              => true,
                'translation_domain'    => 'register'
            ]);
//            ->add('roles', EntityType::class, [
//                'class'                 => 'MedicheckUserBundle:Role',
//                'property'              => 'name',
//                'multiple'              => true,
//            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Form\Model\RegisterUserModel',
        ));
    }

    public function getBlockPrefix()
    {
        return 'medicheck_user';
    }
} 