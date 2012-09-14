<?php

namespace IK\StockBundle\Model\Export;

use IK\StockBundle\Entity\Export as ExportEntity;

class Factory  {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Buzz\Browser
     */
    private $browser;

    public function setEntityManager(\Doctrine\ORM\EntityManager $em){
        $this->em = $em;
    }

    public function setBuzzBrowser(\Buzz\Browser $browser){
        $this->browser = $browser;
    }

    /**
     * @param \IK\StockBundle\Entity\Export $request
     * @return Processor
     */
    public function process( ExportEntity $request ){
        $processor = new Processor($request, $this->em, $this->browser);
        return $processor;
    }
}