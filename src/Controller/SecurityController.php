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

    /**
     * @Route("/api/user", name="get_users", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getUsers(Request $request, Jsoner $jsoner)
    {
        $users= $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return new JsonResponse($jsoner->getJson($users), 200, [],true);
    }

    /**
     * @Route("/api/user/{id}", name="delete_users", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deleteUser($id)
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();
        return (new Response("",204));
    }
}