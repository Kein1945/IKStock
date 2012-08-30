<?php

namespace IK\StockBundle\Model\Attribute;

use IK\StockBundle\Entity\Attribute\Category;
use IK\StockBundle\Entity\Attribute\Value;
use IK\StockBundle\Entity\Product;

abstract class AbstractExtension
{
    protected $category;
    protected $product;
    protected $value;

    function __construct()
    {
        $this->value = new Value();
    }


    function isSortable(){
        return false;
    }

    function isFilterable(){
        return false;
    }

    function isTranslatable(){
        return false;
    }

    function getName(){
        return 'attribute_'.$this->category->getId();
    }

    function __toString(){
        return $this->getName();
    }

    function setCategory(Category $category){
        $this->category = $category;
        $this->value->setCategory($category);
    }
    function getCategory(){
        return $this->category;
    }

    function setValue(Value $value){
        $this->value = $value;
    }

    function getValue(){
        return $this->value;
    }

    function setProduct(Product $product){
        $this->product = $product;
        $this->value->setProduct($product);
    }
}