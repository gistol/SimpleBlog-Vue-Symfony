<?php
/**
 * Created by PhpStorm.
 * User: ultra
 * Date: 20.05.18
 * Time: 14:54
 */

namespace App\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\RouteResource(
 *     "Post",
 *     pluralize=false
 * )
 */
class PostController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @Rest\Get(path="/post/{id}")
     */
    public function getOneAction(Request $request): JsonResponse
    {
        return $this->json($request->query->all());
    }

    public function getAllAction(Request $request): JsonResponse
    {
        return $this->json($request->query->all());
    }

    /**
     * @Rest\Get(path="/post/add")
     */
    public function postAction(Request $request): JsonResponse
    {
        return $this->json($request->request->all());
    }

    /**
     * @Rest\Get(path="/post/{id}")
     */
    public function putAction(Request $request): JsonResponse
    {
        return $this->json($request->request->all());
    }

    /**
     * @Rest\Get(path="/post/{id}")
     */
    public function deleteAction(Request $request): JsonResponse
    {
        return $this->json($request->query->all());
    }
}
