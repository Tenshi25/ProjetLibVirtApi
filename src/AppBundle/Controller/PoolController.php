<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pool;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pool controller.
 *
 * @Route("pool")
 */
class PoolController extends Controller
{
    /**
     * Lists all pool entities.
     *
     * @Route("/", name="pool_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
}
