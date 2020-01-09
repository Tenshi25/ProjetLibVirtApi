<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vm;
use FOS\RestBundle\Controller\FOSRestController;

use JMS\Serializer\SerializationContext;
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

/**
 * Vm controller.
 *
 */
class VmController extends FOSRestController
{
      /**
     * @Get(
     *     path = "/vms/{id}",
     *     name = "app_user_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View(serializerGroups={"detail"})
     */
    public function showAction(vm $vm)
    {
        return $vm;
    }

     /**
     * @Rest\Post(
     *    path = "/vms",
     *    name = "app_user_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter(
     * "vm",
     * converter="fos_rest.request_body",
     * options={
     *  "validator"= {"groups"="Create"} 
     *  }
     * )
     */
    public function createAction(vm $vm, ConstraintViolationList $errors)
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
            
            //return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($vm);
        $em->flush();

        return $this->view($vm, Response::HTTP_CREATED, ['Location' => $this->generateUrl('app_user_show', ['id' => $vm->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
    }
 

    /**
     * Lists all vm entities. 
     * @Rest\Get("/vms", name="app_user_list")
     * @View(serializerGroups={"list"})
     */
    public function listAction()
    {
        $vms = $this->getDoctrine()->getRepository('AppBundle:Vm')->findAll();
        return $vms;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/vms/{id}")
     */

    public function deleteAction(Request $request)
    {
            $em = $this->getDoctrine()->getManager();
            $vm = $em->getRepository('AppBundle:Vm')
            ->find($request->get('id'));
            $em->remove($vm);
            $em->flush();
            
    }


}
