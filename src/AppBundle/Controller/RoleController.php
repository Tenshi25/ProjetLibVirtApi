<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Form\RoleType;
use FOS\RestBundle\Controller\FOSRestController;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use AppBundle\Exception\ResourceValidationException;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


/**
 * Role controller.
 *
 */
class RoleController extends FOSRestController
{
    /**
     * @ApiDoc(
     *    description="Récupère la liste des roles de l'API"
     * )
     * 
     * 
     * @Get(
     *     path = "/roles/{id}",
     *     name = "app_role_show",
     *     requirements = {"id"="\d+"}
     *     description="id du rôle"
     * )
     * @View(serializerGroups={"detail"})
     */
    public function showAction(role $role)
    {
        return $role;
    }

     /**
     * @Rest\Post(
     *    path = "/roles",
     *    name = "app_role_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter(
     * "role",
     * converter="fos_rest.request_body",
     * options={
     *  "validator"= {"groups"="Create"} 
     *  }
     * )
     */
    public function createAction(role $role, ConstraintViolationList $errors)
    {
        if (count($errors)) {
            $message = "the JSON sent contains invalid data: ";
            
            foreach($errors as $error){
                $message .=\sprintf(
                    "Field %s : %s",
                    $error->getPropertyPath(),
                    $error-> getMessage()
                );
            }
            
            throw new ResourceValidationException($message);
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($role);
        $em->flush();

        return $this->view($role, Response::HTTP_CREATED, ['Location' => $this->generateUrl('app_role_show', ['id' => $role->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
    }

     /**
     * Lists all pool entities. 
     * @Rest\Get("/roles", name="app_role_list")
     * @View(serializerGroups={"list"})
     */
    public function listAction()
    {
        $roles = $this->getDoctrine()->getRepository('AppBundle:Role')->findAll();
        /*foreach($roles as $role){
            
        }*/
        return $roles;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/roles/{id}")
     */

    public function deleteAction(Request $request)
    {
            $em = $this->getDoctrine()->getManager();
            $role = $em->getRepository('AppBundle:Role')
            ->find($request->get('id'));
            $em->remove($role);
            $em->flush();
    }

    /**
     * @Rest\View()
     * @Rest\Put("/roles/{id}",requirements = {"id"="\d+"})
     */
    public function updateAction(Request $request)
    {
        $role = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Role')
                ->find($request->get('id'));

        if (empty($role)) {
            return new JsonResponse(['message' => 'role not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(RoleType::class, $role);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($role);
            $em->flush();
            return $role;
        } else {
            return $form;
        }
    }
    /**
     * @Rest\View()
     * @Rest\Patch("/roles/{id}",requirements = {"id"="\d+"})
     */
    public function patchAction(Request $request)
    {
        $role = $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Role')
                ->find($request->get('id'));

        if (empty($role)) {
            return new JsonResponse(['message' => 'role not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(RoleType::class, $role);

        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($role);
            $em->flush();
            return $role;
        } else {
            return $form;
        }
    }



}
