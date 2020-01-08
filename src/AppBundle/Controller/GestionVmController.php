<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Vm;
use AppBundle\Entity\Pool;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;




/**
 * User controller.
 *
 * @Route("")
 */
class GestionVmController extends Controller
{
    /**
     * gestionVm
     *
     * @Route("/home", name="home")
     * @Method({"GET", "POST"})
     */
    public function homeAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

}
