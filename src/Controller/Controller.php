<?php


namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController{

    /**
     * @Route("/test", name="test")
     */
    public function index() {
        $test = "test";
        return new Response($test);
    }
}