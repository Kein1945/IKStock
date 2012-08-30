<?php

namespace IK\StockBundle\Model\Attribute\Extension;

use Symfony\Component\Form\FormBuilderInterface;
use IK\StockBundle\Model\Attribute\AbstractExtension;
use IK\StockBundle\Model\Attribute\ExtensionInterface;

class Text extends AbstractExtension implements ExtensionInterface{

    protected $name = 'Text';

    function setupFormBuilder(FormBuilderInterface $builder){
        $builder->add($this->getName(), 'text', array(
            'label' => $this->category->getName(),
            'required' => $this->category->getRequired()
        ));
    }

    function getData()
    {
        return $this->value->getStrValue();
    }

    function setData($value)
    {
        $this->value->setStrValue($value);
    }
}