<?php

namespace IK\StockBundle\Form\Attribute;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use IK\StockBundle\Entity\DBAL\Attribute\ExtensionType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Name'
            ))
            ->add('required', null, array(
                'label' => 'Required',
                'required' => false
            ))
            ->add('filterable', null, array(
                'label' => 'Filterable',
                'required' => false
            ))
            ->add('sortable', null, array(
                'label' => 'Sortable',
                'required' => false
            ))
            ->add('extension', 'choice', array(
                'choices' => ExtensionType::getListOfTypes(),
                'label' => 'Extension'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IK\StockBundle\Entity\Attribute\Category'
        ));
    }

    public function getName()
    {
        return 'ik_stockbundle_attribute_categorytype';
    }
}
