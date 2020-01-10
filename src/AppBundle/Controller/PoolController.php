<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pool;
use AppBundle\Form\PoolType;
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
use Symfony\Component\HttpFoundation\JsonResponse;


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
     * @View(serializerGroups={"detail"})
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
     * @View(serializerGroups={"list"})
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

    /**
     * @Rest\View()
     * @Rest\Put("/pools/{id}",requirements = {"id"="\d+"})
     */
    public function updateAction(Request $request)
    {
        $pool = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Pool')
                ->find($request->get('id'));

        if (empty($pool)) {
            return new JsonResponse(['message' => 'pool not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PoolType::class, $pool);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($pool);
            $em->flush();
            return $pool;
        } else {
            return $form;
        }
    }
    /**
     * @Rest\View()
     * @Rest\Patch("/pools/{id}",requirements = {"id"="\d+"})
     */
    public function patchAction(Request $request)
    {
        $pool = $this->getDoctrine()->getManager()
                ->getRepository('AppBundle:Pool')
                ->find($request->get('id'));

        if (empty($pool)) {
            return new JsonResponse(['message' => 'pool not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PoolType::class, $pool);

        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($pool);
            $em->flush();
            return $pool;
        } else {
            return $form;
        }
    }

}
