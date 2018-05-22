<?php
/**
 * Created by PhpStorm.
 * User: ultra
 * Date: 20.05.18
 * Time: 14:54
 */

namespace App\Controller\Api;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\RouteResource(
 *     "Comment",
 *     pluralize=false
 * )
 */
class CommentController extends FOSRestController implements ClassResourceInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em->getRepository(Comment::class);
    }

    public function getAction(): JsonResponse
    {
        return $this->json($this->em->findAll());
    }

    /**
     * @Rest\Get(path="/comment/{slug}")
     */
    public function getOneAction(Post $post): JsonResponse
    {
        return $this->json($post->getComments());
    }

    /**
     * @Rest\Get(path="/comment/add/{slug}")
     */
    public function postAction(Request $request, Post $post): JsonResponse
    {
        return $this->json($request->request->all());
    }

    /**
     * @Rest\Get(path="/comment/{id}")
     */
    public function putAction(Request $request): JsonResponse
    {
        return $this->json($request->request->all());
    }

    /**
     * @Rest\Get(path="/comment/{id}")
     */
    public function deleteAction(Request $request): JsonResponse
    {
        return $this->json($request->query->all());
    }
}
