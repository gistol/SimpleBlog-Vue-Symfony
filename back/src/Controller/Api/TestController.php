<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\RouteResource(
 *     "Test",
 *     pluralize=false
 * )
 */
class TestController extends FOSRestController implements ClassResourceInterface
{
    public function getAction(Request $request): JsonResponse
    {
        return $this->json($request->query->all());
    }

    public function postAction(Request $request): JsonResponse
    {
        return $this->json($request->request->all());
    }

    public function putAction(Request $request): JsonResponse
    {
        return $this->json($request->request->all());
    }

    public function deleteAction(Request $request): JsonResponse
    {
        return $this->json($request->query->all());
    }
}
