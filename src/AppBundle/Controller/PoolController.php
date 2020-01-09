<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pool;
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


/**
 * Pool controller.
 *
 */
class PoolController extends FOSRestController
{
    /**
     * @Get(
     *     path = "/pools/{id}",
     *     name = "app_pool_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View
     */
    public function showAction(pool $pool)
    {
        return $pool;
    }

     /**
     * @Rest\Post(
     *    path = "/pools",
     *    name = "app_pool_create"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter(
     * "pool",
     * converter="fos_rest.request_body",
     * options={
     *  "validator"= {"groups"="Create"} 
     *  }
     * )
     */
    public function createAction(pool $pool, ConstraintViolationList $errors)
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

        $em->persist($pool);
        $em->flush();

        return $this->view($pool, Response::HTTP_CREATED, ['Location' => $this->generateUrl('app_pool_show', ['id' => $pool->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
    }

     /**
     * Lists all pool entities. 
     * @Rest\Get("/pools", name="app_pool_list")
     * @View
     */
    public function listAction()
    {
        $pools = $this->getDoctrine()->getRepository('AppBundle:Pool')->findAll();
        return $pools;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/pools/{id}")
     */

    public function deleteAction(Request $request)
    {
            $em = $this->getDoctrine()->getManager();
            $pool = $em->getRepository('AppBundle:Pool')
            ->find($request->get('id'));
            $em->remove($pool);
            $em->flush();
    }

}
