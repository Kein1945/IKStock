<?php

namespace IK\StockBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Name'
            ))
            ->add('slug', null, array(
                'label' => 'Seo slug'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IK\StockBundle\Entity\Category'
        ));
    }

    public function getName()
    {
        return 'ik_stockbundle_categorytype';
    }
}
