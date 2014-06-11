<?php

namespace Tritoq\Bundle\TpanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VhostType extends AbstractType
{
    private $nodes;

    public function setNodes($nodes)
    {
        $this->nodes = $nodes;

    }

    private function getAddressIP()
    {
        $data = array();
        //

        foreach ($this->nodes as $node) {
            $data[$node['ip']] = $node['host'] . ' [' . $node['ip'] . ']';
        }

        return $data;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', null, array('attr' => array('class' => 'form-control'), 'label' => 'Usuário'))
            ->add('password', null, array('attr' => array('class' => 'form-control'), 'label' => 'Senha'))
            ->add('domain', null, array('attr' => array('class' => 'form-control'), 'label' => 'Domínio'))

            ->add('ip', 'choice', array('choices' => $this->getAddressIP() ,  'attr' => array('class' => 'form-control'), 'label' => 'IP'))

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
