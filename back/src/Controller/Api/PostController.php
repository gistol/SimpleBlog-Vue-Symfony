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

/**
 * @Rest\RouteResource(
 *     "Post",
 *     pluralize=false
 * )
 */
class PostController extends FOSRestController implements ClassResourceInterface
{
    private $em;
    private $emp;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->emp = $em->getRepository(Post::class);
    }

    public function getAction(Request $request): JsonResponse
    {
        $param = $request->query->all();
        $posts = $this->emp->findAllFromTo($param['start'], $param['limit']);
        $numberPosts = $this->emp->findNumberRows();

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
        $data = $request->request->all();

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
