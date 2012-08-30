<?php

namespace IK\StockBundle\Entity\DBAL\Attribute;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use IK\StockBundle\Entity\DBAL\EnumType;
use IK\StockBundle\Model\Attribute\Provider as AttributeProvider;

class ExtensionType extends EnumType{
    protected $name = 'attributeextensiontype';
    function getValues(){
        return AttributeProvider::getExtensionList();
    }

    public static function getListOfTypes(){
        $types = AttributeProvider::getExtensionList();
        foreach($types as $extension){
            $t = explode('/', $extension);
            $extension_name = array_pop( $t );
            $return[$extension] = $extension_name;
        }
        return $return;
    }
}