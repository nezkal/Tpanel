<?php

namespace Tritoq\Bundle\TpanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VhostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', null, array('attr' => array('class' => 'form-control'), 'label' => 'Usuário'))
            ->add('password', null, array('attr' => array('class' => 'form-control'), 'label' => 'Usuário'))
            ->add('domain', null, array('attr' => array('class' => 'form-control'), 'label' => 'Domínio'))
            ->add('ip', null, array('attr' => array('class' => 'form-control'), 'label' => 'IP'))
            ->add('adminEmail', null, array('attr' => array('class' => 'form-control'), 'label' => 'Admin E-mail'))
            ->add('vhost', null, array('attr' => array('class' => 'form-control', 'rows' => 30)))
            ->add('nginx', null, array('attr' => array('class' => 'form-control', 'rows' => 30)));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Tritoq\Bundle\TpanelBundle\Entity\Vhost'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tritoq_bundle_tpanelbundle_vhost';
    }
}
