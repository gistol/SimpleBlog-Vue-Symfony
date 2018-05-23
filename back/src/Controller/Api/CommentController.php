<?php

namespace App\Controller\Api;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

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
        $this->em = $em;
    }

    /**
     * @Rest\Post(path="/comment/{slug}")
     */
    public function postAction(Post $post, Request $request, TokenStorageInterface $storage): JsonResponse
    {
        $token = $storage->getToken();

        if($user = $token->getUser()) {
            $content = $request->request->get('content');

            $comment = new Comment();
            $comment->setContent($content);
            $comment->setAuthor($user);
            $post->addComment($comment);

            $this->em->persist($comment);
            $this->em->flush();

            return $this->json('Comment add', Response::HTTP_CREATED);
        }

        return $this->json('Not add comment', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @Rest\Put(path="/comment/{id}")
     */
    public function putAction(Request $request): JsonResponse
    {
        return $this->json($request->request->all());
    }

    /**
     * @Rest\Delete(path="/comment/{id}")
     */
    public function deleteAction(Request $request): JsonResponse
    {
        return $this->json($request->query->all());
    }
}
