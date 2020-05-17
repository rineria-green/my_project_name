<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="login", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function login(Request $request)
    {
        $user = $this->getUser();

        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);
    }
//    /**
//     * @Route("/api/admin/login", name="admin_login", methods={"POST"})
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\JsonResponse
//     */
//    public function adminLogin(Request $request)
//    {
//        $user = $this->getUser();
//
//        return $this->json([
//            'username' => $user->getUsername(),
//            'roles' => $user->getRoles(),
//        ]);
//    }
}