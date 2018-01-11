<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 23/05/14
 * Time: 21:52
 */

namespace Medicheck\CmsBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label'                 => 'account.firstname',
                'required'              => true,
            ])
            ->add('lastname', TextType::class, [
                'label'                 => 'account.lastname',
                'required'              => true,
            ])
            ->add('numSecu', TextType::class, [
                'label'                 => 'account.numsecu',
                'required'              => true,
            ])
            ->add('birthday', BirthdayType::class, [
                'label'                 => 'account.birthday',
                'required'              => false,
                'format'                => 'dd MMMM yyyy'
            ])
            ->add('passwordUnencoded', RepeatedType::class, [
                'type'                  => PasswordType::class,
                'invalid_message'       => 'account.error.password',
                'required'              => false,
                'first_options'         => [
                    'label'                     => 'account.password.first',
                    'error_bubbling'            => true
                ],
                'second_options'        => [
                    'label'                     => 'account.password.second',
                    'error_bubbling'            => true
                ]
            ])
            ->add('email', EmailType::class, [
                'label'                 => 'account.email',
                'required'              => true,
            ])
            ->add('recipients', CollectionType::class, [
                'entry_type'            => RecipientType::class,
                'allow_add'             => true,
                'allow_delete'          => true,
                'by_reference'          => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'                => 'Medicheck\UserBundle\Entity\User',
            'translation_domain'        => 'account'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'medicheck_account';
    }
} 