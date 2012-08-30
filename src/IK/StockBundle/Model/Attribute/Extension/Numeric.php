<?php

namespace IK\StockBundle\Model\Attribute\Extension;

use Symfony\Component\Form\FormBuilderInterface;
use IK\StockBundle\Model\Attribute\AbstractExtension;
use IK\StockBundle\Model\Attribute\ExtensionInterface;

class Numeric extends AbstractExtension implements ExtensionInterface{

    protected $name = 'Numeric';

    function setupFormBuilder(FormBuilderInterface $builder){
        $builder->add($this->getName(), 'number', array(
            'label' => $this->category->getName(),
            'required' => $this->category->getRequired()
        ));
    }

    function getData()
    {
        return $this->value->getIntValue();
    }

    function setData($value)
    {
        $this->value->setIntValue($value);
    }
}