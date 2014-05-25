<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 23/05/14
 * Time: 21:52
 */

namespace Medicheck\CmsBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccountType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array('label' => 'register.firstname', 'required' => true))
            ->add('lastname', null, array('label' => 'register.lastname', 'required' => true))
            ->add('numSecu', null, array('label' => 'register.numsecu', 'required' => true))
            ->add('passwordUnencoded', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'register.error.password',
                'required' => false,
                'first_options'  => array(
                    'label' => 'register.password',
                    'error_bubbling' => true
                ),
                'second_options' => array(
                    'label' => 'register.password.validation',
                    'error_bubbling' => true
                ),

            ))
            ->add('email', "email", array('label' => 'register.email', 'required' => true))
            ->add('recipients', 'collection', array(
                'type' => new RecipientType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Medicheck\UserBundle\Entity\User',
        ));
    }

    public function getName()
    {
        return 'medicheck_account';
    }

} 