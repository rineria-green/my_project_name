<?php


namespace App\Controller;


use App\Entity\User;
use App\Service\Jsoner;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user", name="create_user", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createUser(Request $request, Jsoner $jsoner)
    {
        $content = $request->getContent();
        $content = json_decode($content, true);
        $user = new User();
        $user->setEmail($content["email"]);
        if (isset($content["phone"]))
            $user->setPhone($content["phone"]);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($user->generationPassword());
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse($jsoner->getJson($user), 201, [], true);
    }

    /**
     * @Route("/api/user/{id}/password", name="change_password", methods={"PUT"})
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function changePassword (Request $request, $id, Jsoner $jsoner)
    {
        $content = $request->getContent();
        $content = json_decode($content, true);
        $user= $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        if ($content["password"] === $user->getPassword()){
            $user->setPassword($content["new_password"]);
        }
        else{
            return (new Response("", 403));
        }
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse($jsoner->getJson($user), 201, [], true);
    }

    /**
     * @Route("/api/user", name="get_users", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getUsers(Request $request, Jsoner $jsoner)
    {
//        $this->denyAccessUnlessGranted('ROLE_USER');
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
//        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);
        if (((int)$id === 1)||((int)$id === 2)) {
            return (new Response("", 400));
        }
        else {
            $this->getDoctrine()->getManager()->remove($user);
            $this->getDoctrine()->getManager()->flush();
            return (new Response("", 204));
        }
    }
}