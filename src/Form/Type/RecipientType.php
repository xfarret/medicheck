<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 23/05/14
 * Time: 22:16
 */

namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipientType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numSecu', TextType::class, [
                'label'                 => 'register.numsecu',
                'required'              => false,
            ])
            ->add('firstname', TextType::class, [
                'label'                 => 'register.firstname',
                'required'              => true,
            ])
            ->add('lastname', TextType::class, [
                'label'                 => 'register.lastname',
                'required'              => true,
            ])
            ->add('birthday', BirthdayType::class, [
                'label'                 => 'register.birthday',
                'required'              => false,
            ])
            ->add('isChild', CheckboxType::class, [
                'required'              => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'                => 'App\Entity\Recipient',
            'translation_domain'        => 'account'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'medicheck_recipient';
    }
} 