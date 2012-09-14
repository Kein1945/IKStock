<?php

namespace IK\StockBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use IK\StockBundle\Entity\Product;

/**
 * Product controller.
 *
 * @Route("/stock/export")
 */
class ExportController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/all", name="stock_export")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IKStockBundle:Product')->findAll();

        $data = array();

        foreach($entities as $product){
            $product_raw_data = array(
                'name' => $product->getName(),
                'article' => $product->getArticle(),
                'quantity' => $product->getQuantity()
            );
            foreach( $product->getExtensions() as $extension){
                $product_raw_data[$extension->getCategory()->getName()] = $extension->getData();
            }
            $data[] = $product_raw_data;
        }
        $response = new Response(json_encode($data), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
