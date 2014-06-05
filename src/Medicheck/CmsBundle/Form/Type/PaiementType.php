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
            ->add('createAt', null, array('label' => 'paiements.date', 'required' => true))
            ->add('act', null, array('label' => 'paiements.act', 'required' => true))
            ->add('practitioner', null, array('label' => 'paiements.practitioner', 'required' => false))
            ->add('cost', null, array('label' => 'paiements.amount', 'required' => true))
            ->add('deductible', null, array('label' => 'paiements.deductible', 'required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Medicheck\CmsBundle\Entity\Paiement',
        ));
    }

    public function getName()
    {
        return 'medicheck_paiement';
    }

} 