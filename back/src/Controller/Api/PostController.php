<?php
/**
 * Created by PhpStorm.
 * User: ultra
 * Date: 20.05.18
 * Time: 14:54
 */

namespace App\Controller\Api;

use App\Entity\Post;
use App\Form\PostType;
use App\Utils\Slug;
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
 *     "Post",
 *     pluralize=false
 * )
 */
class PostController extends FOSRestController implements ClassResourceInterface
{
    private $em;
    private $storage;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $storage)
    {
        $this->em = $em;
        $this->storage = $storage;
    }

    public function getAction(Request $request): JsonResponse
    {
        $emPost = $this->em->getRepository(Post::class);

        $param = $request->query->all();
        $posts = $emPost->findAllFromTo($param['start'], $param['limit']);
        $numberPosts = $emPost->findNumberRows();

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
        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($post, 'json');

        return $this->json($json);
    }

    /**
     * @Rest\Post(path="/post")
     */
    public function postAction(Request $request): JsonResponse
    {
        $token = $this->storage->getToken();
        $data = $request->request->all();

        if($token->getRoles() === 'ROLE_ADMIN')
            return $this->json('Only the admin can edit the post', Response::HTTP_UNAUTHORIZED);

        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->submit($data);


        if($form->isValid()) {
            $post->setSlug(Slug::slugger($post->getTitle()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->json(['message' => 'Post success created'], Response::HTTP_CREATED);
        }

        return $this->json('Error', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Put(path="/post/{slug}")
     */
    public function putAction(Post $post, Request $request): JsonResponse
    {

        $token = $this->storage->getToken();
        $data = $request->request->all();

        if($token->getRoles() === 'ROLE_ADMIN')
            return $this->json('Only the admin can edit the post', Response::HTTP_UNAUTHORIZED);

        $form = $this->createForm(PostType::class, $post);
        $form->submit($data);


        if($form->isValid()) {
            $post->setSlug(Slug::slugger($post->getTitle()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->json(['message' => 'Post success edit'], Response::HTTP_OK);
        }

        return $this->json('Error', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Delete(path="/post/{slug}")
     */
    public function deleteAction(Post $post): JsonResponse
    {
        $token = $this->storage->getToken();
        if($token->getRoles() === 'ROLE_ADMIN')
            return $this->json('Only the admin can edit the post', Response::HTTP_UNAUTHORIZED);

        $post->setDeletedAt(new \DateTime());
        $this->em->persist($post);
        $this->em->flush();

        return $this->json('Deleted', Response::HTTP_OK);
    }
}
