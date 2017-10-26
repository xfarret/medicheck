<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 05/06/14
 * Time: 22:05
 */

namespace Medicheck\CmsBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaiementType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createAt', TextType::class, [
                'label'                 => 'paiements.date',
                'required'              => true,
                'translation_domain'    => 'paiements',
                'attr'                  => [
                    'placeholder'               => 'paiements.placeholder.date_format'
                ]
            ])
            ->add('act', TextType::class, [
                'label'                 => 'paiements.act',
                'required'              => true,
                'translation_domain'    => 'paiements',
            ])
            ->add('practitioner', TextType::class, [
                'label'                 => 'paiements.practitioner',
                'required'              => false,
                'translation_domain'    => 'paiements',
            ])
            ->add('cost', TextType::class, [
                'label'                 => 'paiements.amount',
                'required'              => true,
                'translation_domain'    => 'paiements',
                'attr'                  => [
                    'placeholder'               => 'paiements.placeholder.money'
                ]
            ])
            ->add('deductible', TextType::class, [
                'label'                 => 'paiements.deductible',
                'required'              => false,
                'translation_domain'    => 'paiements',
                'attr'                  => [
                    'placeholder'               => 'paiements.placeholder.money'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Medicheck\CmsBundle\Form\Model\PaiementModel',
        ]);
    }

    public function getBlockPrefix()
    {
        return 'medicheck_paiement';
    }

} 