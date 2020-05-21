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
        if ($content["phone"] != null)
            $user->setPhone($content["phone"]);
        $user->setPassword($this->generationPassword());
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
        if ((int)$id === 1) {
            return (new Response("", 400));
        }
        else {
            $this->getDoctrine()->getManager()->remove($user);
            $this->getDoctrine()->getManager()->flush();
            return (new Response("", 204));
        }
    }

    private function generationPassword(){
        $chars="1234567890abcdxyzABCDXYZ";
        $max=5;
        $size=StrLen($chars)-1;
        $password=null;
        while($max--)
            $password.=$chars[rand(0,$size)];
        return $password;
    }
}