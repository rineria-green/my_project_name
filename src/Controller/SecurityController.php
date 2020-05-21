<?php


namespace App\Controller;


use App\Entity\User;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Jsoner;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/user/login", name="login", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request, Jsoner $jsoner)
    {
        $user = $this->getUser();
        $serializer = SerializerBuilder::create()->build();
//        $data = [
//            'username' => $user->getUsername(),
//            'roles' => $user->getRoles(),
//        ];
        return new JsonResponse($jsoner->getJson($user), 200, [],true);
    }
}