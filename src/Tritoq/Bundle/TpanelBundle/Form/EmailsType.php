<?php

namespace Tritoq\Bundle\TpanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmailsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, array('attr' => array('class' => 'form-control'), 'label' => 'E-mail'))
            ->add('password', null, array('attr' => array('class' => 'form-control'), 'label' => 'Senha'))
            ->add('dominio', null, array('attr' => array('class' => 'form-control'), 'label' => 'Domínio'))

            ->add('path', null, array('attr' => array('class' => 'form-control'), 'label' => 'Path'))
            ->add('postmaster', null, array('attr' => array('class' => 'form-control'), 'label' => 'Post Master'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Tritoq\Bundle\TpanelBundle\Entity\Emails'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tritoq_bundle_tpanelbundle_emails';
    }
}
