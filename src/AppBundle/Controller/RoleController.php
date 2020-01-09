<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use FOS\RestBundle\Controller\FOSRestController;


use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
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

/**
 * Role controller.
 *
 */
class RoleController extends FOSRestController
{
    /**
     * @Get(
     *     path = "/roles/{id}",
     *     name = "app_role_show",
     *     requirements = {"id"="\d+"}
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


}
