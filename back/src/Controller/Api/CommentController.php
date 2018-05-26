<?php

namespace App\Controller\Api;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
        if(!$token = $storage->getToken())
            return $this->json('You must a logged', Response::HTTP_UNAUTHORIZED);

        $data = $request->request->all();

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->submit($data);


        if($form->isValid()) {
            $comment->setAuthor($token->getUser());
            $post->addComment($comment);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->json(['message' => 'Comment success created'], Response::HTTP_CREATED);
        }

        return $this->json('Error', Response::HTTP_BAD_REQUEST);
    }
}
