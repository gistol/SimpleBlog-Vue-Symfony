<?php
/**
 * Created by PhpStorm.
 * User: ultra
 * Date: 20.05.18
 * Time: 14:54
 */

namespace App\Controller\Api;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
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
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em->getRepository(Post::class);
    }

    public function getAction(Request $request): JsonResponse
    {
        $param = $request->query->all();
        $posts = $this->em->findAllFromTo($param['start'], $param['limit']);
        $numberPosts = $this->em->findNumberRows();

        return $this->json([
            'posts' => $posts,
            'number' => $numberPosts
        ]);
    }

    /**
     * @Rest\Get(path="/post/{slug}")
     */
    public function getOneAction(Post $post): JsonResponse
    {
        return $this->json($post);
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
