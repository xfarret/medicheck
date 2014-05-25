<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 23/05/14
 * Time: 22:16
 */

namespace Medicheck\CmsBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipientType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array('label' => 'register.firstname', 'required' => true))
            ->add('lastname', null, array('label' => 'register.lastname', 'required' => true))
            ->add('numSecu', null, array('label' => 'register.numsecu', 'required' => false))
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
        return 'medicheck_recipient';
    }
} 