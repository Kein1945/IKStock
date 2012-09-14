<?php

namespace IK\StockBundle\Model\Export;

use IK\StockBundle\Entity\Export as ExportEntity;

class Processor {

    /**
     * @var ExportEntity
     */
    private $request;

    /**
     * @var \Buzz\Browser
     */
    private $browser;

    /**
     * @var \Buzz\Message\Response
     */
    private $response;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function __construct(ExportEntity $request, \Doctrine\ORM\EntityManager $em, \Buzz\Browser $browser){
        $this->request = $request;
        $this->em = $em;
        $this->browser = $browser;
    }

    /**
     * @return bool
     */
    public function start(){
        if( $this->isClientStorageActual() )
            return true;

        $data = $this->buildExportData();

        $response = $this->sendData( $data );

        return $this->proceedClientResponse( $response );
    }

    /**
     * @param $data
     * @return \Buzz\Message\Response
     */
    protected function sendData( $data ){
        return $this->browser->post( $this->request->getUrl().'/export/'.$this->request->getClientKey(), array(), \http_build_query($data) );
    }

    /**
     * @param $response
     * @return mixed
     */
    protected function proceedClientResponse(\Buzz\Message\Response $response ){
        $this->response = $response;
        return $this->response->isOk();
    }

    public function getResponse(){
        return $this->response;
    }

    protected function buildExportData(){
        $this->request->getLastUpdate();
        $entities = $this->em->getRepository('IKStockBundle:Product')->findAll();
        $products = array();
        foreach ($entities as $entity) {
            $data = array(
                'page' => array('title' => $entity->getName()),
                'seo' => array('title' => $entity->getName()),
                'description' => $entity->getName(),
            );
            foreach($entity->getExtensions() as $extension){
                $data[$extension->getCategory()->getName()] = $extension->getData();
            }

            $products[] = array(
                'name' => $entity->getName(),
                'article' => $entity->getArticle(),
                'quantity' => $entity->getQuantity(),
                'data' => $data,
                'tags' => array($entity->getCategory()->getSlug())
            );
        }
        $export = array(
            'products' => $products
        );
        return $export;
    }

    /**
     * Compare last products update from client and stock
     * @return bool
     */
    private function isClientStorageActual(){
        return false;
    }
}