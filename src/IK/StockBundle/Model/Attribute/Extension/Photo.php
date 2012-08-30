<?php

namespace IK\StockBundle\Model\Attribute\Extension;

use Symfony\Component\Form\FormBuilderInterface;
use IK\StockBundle\Model\Attribute\AbstractExtension;
use IK\StockBundle\Model\Attribute\ExtensionInterface;

class Photo extends AbstractExtension implements ExtensionInterface{

    protected $name = 'Numeric';

    function setupFormBuilder(FormBuilderInterface $builder){
        $builder->add($this->getName(), 'text', array(
            'label' => $this->category->getName()
        ));
    }
}