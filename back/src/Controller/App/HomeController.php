<?php

namespace App\Controller\App;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/{slug}", name="home")
     */
    public function index(Post $post): Response
    {
        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($post, 'json');

        return $this->json($json);
//        return $this->render('home/index.html.twig', [
//            'post' => $post
//        ]);
    }

    /**
     * @Route("/ping", name="ping")
     */
    public function ping(): JsonResponse
    {
        return $this->json('ping');
    }
}
