<?php
/**
 * Created by PhpStorm.
 * User: ultra
 * Date: 20.05.18
 * Time: 14:54
 */

namespace App\Controller\Api;

use App\Entity\Post;
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

        if($user = $token->getRoles() === 'ROLE_ADMIN')
            return $this->json('Only the admin can edit the post', Response::HTTP_UNAUTHORIZED);
        elseif(array_key_exists('title', $data) && array_key_exists('content', $data))
            return $this->json('Required data title and content', Response::HTTP_BAD_REQUEST);
        elseif(strlen($data['title']) < 15 || strlen($data['content']) < 50)
            return $this->json('Title or content is too short. title >= 15; content >= 50', Response::HTTP_BAD_REQUEST);


        $post = new Post();

        $post->setTitle($data['title']);
        $post->setSlug(Slug::slugger($post->getTitle()));
        $post->setContent($data['content']);

        $this->em->persist($post);
        $this->em->flush();

        return $this->json('Post edit', Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put(path="/post/{slug}")
     */
    public function putAction(Post $post, Request $request): JsonResponse
    {
        $data = $request->request->all();
        $post->setTitle($data['title']);
        $post->setSlug(Slug::slugger($post->getTitle()));
        $post->setContent($data['content']);

        $this->em->persist($post);
        $this->em->flush();

        return $this->json('Post edit', Response::HTTP_OK);
    }

    /**
     * @Rest\Delete(path="/post/{slug}")
     */
    public function deleteAction(Post $post): JsonResponse
    {
        $post->setDeletedAt(new \DateTime());
        $this->em->persist($post);
        $this->em->flush();

        return $this->json('Deleted', Response::HTTP_OK);
    }
}
