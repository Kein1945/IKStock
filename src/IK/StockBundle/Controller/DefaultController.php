<?php

namespace IK\StockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Default controller.
 *
 * @Route("/stock")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/dashboard", name="stock_dashboard")
     * @Template()
     */
    public function dashboardAction()
    {
        return array();
    }
}
