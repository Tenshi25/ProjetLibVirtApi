<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;

/**
 * Vm controller.
 *
 */
class VmController extends Controller
{
   /**
     * @Route("/vms", name="vms_create")
     * @Method({"POST"})
     */
    public function newAction(Request $request)
    {
        $data = $request->getContent();
        $vm = $this->get('jms_serializer')->deserialize($data, 'AppBundle\Entity\Vm', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($vm);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }
 

    /**
     * @Route("/vms", name="vms_list")
     * @Method({"GET"})
     */
    public function listVmsAction()
    {
        $vms = $this->getDoctrine()->getRepository('AppBundle:Vm')->findAll();

        $data = $this->get('jms_serializer')->serialize($vms, 'json', SerializationContext::create()->setGroups(array('list')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/vms/{id}", name="vms_show")
     * @Method({"GET"})
     */
    public function showVmsAction(Vm $vm)
    {
        $data = $this->get('jms_serializer')->serialize($vm, 'json', SerializationContext::create()->setGroups(array('detail')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    /**
     * @Route("/vms/{id}", name="vms_delete")
     * @Method({"DELETE"})
     */

    public function deleteAction(Request $request)
    {
            $vm = $this->get('jms_serializer')->deserialize($data, 'AppBundle\Entity\Vm', 'json');
            $em = $this->getDoctrine()->getManager();
            $em->remove($vm);
            $em->flush();
            return new Response('delete OK', Response::HTTP_DELETE);
    }



}
