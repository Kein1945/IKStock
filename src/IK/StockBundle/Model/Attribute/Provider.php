<?php

namespace IK\StockBundle\Model\Attribute;

class Provider {

    protected static $classMapList = null;

    public static function getExtensionList(){
        if( null == self::$classMapList) self::$classMapList = self::_getExtensionList();
        return self::$classMapList;
    }

    private static function _getExtensionList(){
        $classMap = array();
        foreach(new \DirectoryIterator(__DIR__.DIRECTORY_SEPARATOR.'Extension') as $file)
            if(!$file->isDir() && !$file->isDot())
                $classMap[] =  str_replace('\\','/', __NAMESPACE__.'\\Extension\\'.$file->getBasename('.php'));
        return $classMap;
    }

    public static function getExtension($name){
        $className = '\\'.str_replace('/','\\', $name);
        return new $className;
    }
}