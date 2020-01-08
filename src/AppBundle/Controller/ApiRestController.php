<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ApiRest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Apirest controller.
 *
 * @Route("apirest")
 */
class ApiRestController extends Controller
{
    /**
     * Lists all apiRest entities.
     *
     * @Route("/", name="apirest_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $apiRests = $em->getRepository('AppBundle:ApiRest')->findAll();

        return $this->render('apirest/index.html.twig', array(
            'apiRests' => $apiRests,
        ));
    }

    /**
     * Creates a new apiRest entity.
     *
     * @Route("/new", name="apirest_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $apiRest = new Apirest();
        $form = $this->createForm('AppBundle\Form\ApiRestType', $apiRest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($apiRest);
            $em->flush();

            return $this->redirectToRoute('apirest_show', array('id' => $apiRest->getId()));
        }

        return $this->render('apirest/new.html.twig', array(
            'apiRest' => $apiRest,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a apiRest entity.
     *
     * @Route("/{id}", name="apirest_show")
     * @Method("GET")
     */
    public function showAction(ApiRest $apiRest)
    {
        $apiRest = new ApiRest();
        $apiRest
            ->setTitle('Mon premier article')
            ->setContent('Le contenu de mon article.')
        ;
        $data = $this->get('jms_serializer')->serialize($apiRest, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Displays a form to edit an existing apiRest entity.
     *
     * @Route("/{id}/edit", name="apirest_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ApiRest $apiRest)
    {
        $deleteForm = $this->createDeleteForm($apiRest);
        $editForm = $this->createForm('AppBundle\Form\ApiRestType', $apiRest);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('apirest_edit', array('id' => $apiRest->getId()));
        }

        return $this->render('apirest/edit.html.twig', array(
            'apiRest' => $apiRest,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a apiRest entity.
     *
     * @Route("/{id}", name="apirest_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ApiRest $apiRest)
    {
        $form = $this->createDeleteForm($apiRest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($apiRest);
            $em->flush();
        }

        return $this->redirectToRoute('apirest_index');
    }

    /**
     * Creates a form to delete a apiRest entity.
     *
     * @param ApiRest $apiRest The apiRest entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ApiRest $apiRest)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('apirest_delete', array('id' => $apiRest->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
