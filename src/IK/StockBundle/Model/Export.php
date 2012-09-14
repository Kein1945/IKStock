<?php

namespace IK\StockBundle\Model;

use IK\StockBundle\Entity\Export as ExportEntity;

class Export  {

    /**
     * @var ExportEntity
     */
    private $request;

    function __construct(ExportEntity $request){
        $this->request = $request;
    }

    function start(){
        if( $this->isClientStorageActual() )
            return true;

        $data = $this->buildExportData();


    }

    function buildExportData(){
        $this->request->getLastUpdate();
    }

    /**
     * Compare last products update from client and stock
     * @return bool
     */
    function isClientStorageActual(){
        return false;
    }
}