<?php

namespace IK\StockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    protected $extensions = array();
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('article')
            ->add('name')
            ->add('quantity')
        ;
        foreach($options['data']->getExtensions() as $key => $extension){
            call_user_func_array(array($extension, 'setupFormBuilder'), array($builder));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IK\StockBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'ik_stockbundle_producttype';
    }
}
