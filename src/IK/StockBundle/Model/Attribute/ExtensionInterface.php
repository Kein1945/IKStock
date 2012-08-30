<?php

namespace IK\StockBundle\Model\Attribute;

use Symfony\Component\Form\FormBuilderInterface;
use IK\StockBundle\Entity\Attribute\Category;
use IK\StockBundle\Entity\Attribute\Value;
use IK\StockBundle\Entity\Product;

interface ExtensionInterface {
    function isSortable();

    function isFilterable();

    function isTranslatable();

    function getName();

    function __toString();

    function getData();

    function setData($value);

    function setupFormBuilder(FormBuilderInterface $builder);

    function setCategory(Category $category);

    function setValue(Value $value);
}