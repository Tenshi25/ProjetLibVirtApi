<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Role controller.
 *
 * @Route("role")
 */
class RoleController extends Controller
{
    /**
     * Lists all role entities.
     *
     * @Route("/", name="role_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

}
