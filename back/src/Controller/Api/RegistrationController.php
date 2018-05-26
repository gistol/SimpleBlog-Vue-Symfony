<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Form\UserType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Rest\RouteResource(
 *     "Register",
 *     pluralize=false
 * )
 */
class RegistrationController extends FOSRestController implements ClassResourceInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function postAction(Request $request): JsonResponse
    {
        $data = $request->request->all();

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($data);


        if($form->isValid()) {
            $password = $this->passwordEncoder->encodePassword($user, $request->request->get('password'));
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->json(['user' => $user, 'message' => 'User success created'], Response::HTTP_CREATED);
        }

        return $this->json(['form' => $form], Response::HTTP_BAD_REQUEST);
    }
}
