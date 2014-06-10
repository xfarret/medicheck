<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 05/06/14
 * Time: 22:05
 */

namespace Medicheck\CmsBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaiementType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createAt', null, array('label' => 'paiements.date', 'required' => true, 'attr' => array("placeholder" => "jj/mm/aaaa") ))
            ->add('act', null, array('label' => 'paiements.act', 'required' => true))
            ->add('practitioner', null, array('label' => 'paiements.practitioner', 'required' => false))
            ->add('cost', null, array('label' => 'paiements.amount', 'required' => true, 'attr' => array("placeholder" => "0.00")))
            ->add('deductible', null, array('label' => 'paiements.deductible', 'required' => false, 'attr' => array("placeholder" => "0.00")))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Medicheck\CmsBundle\Form\Model\PaiementModel',
        ));
    }

    public function getName()
    {
        return 'medicheck_paiement';
    }

} 