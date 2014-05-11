<?php
/**
 * Created by PhpStorm.
 * User: xfarret
 * Date: 05/05/14
 * Time: 13:00
 */

namespace Medicheck\UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LoginType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array(
                'label' => 'login.username',
                'required' => true,
            ))
            ->add('password', 'password', array(
                'label' => 'login.password',
                'required' => true
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'csrf_field_name' => '_csrf_token',
            'intention'       => 'authenticate',
        ));
    }

    public function getName()
    {
        return 'user_login';
    }

} 