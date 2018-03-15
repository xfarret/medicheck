<?php
/**
 * Created by PhpStorm.
 * User: xfarret
 * Date: 05/05/14
 * Time: 13:00
 */

namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('username', TextType::class, [
                'label'                 => 'login.username',
                'required'              => true,
                'translation_domain'    => 'login',
                'attr'                  => [
                    'placeholder'               => 'login.placeholder.username',
                    'class'                     => 'form-control',
                    'autofocus'                 => 'autofocus'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label'                 => 'login.password',
                'required'              => true,
                'translation_domain'    => 'login',
                'attr'                  => [
                    'placeholder'               => 'login.placeholder.password',
                    'class'                     => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'csrf_field_name' => '_csrf_token'
        ));
    }

    public function getBlockPrefix()
    {
        return 'user_login';
    }
}