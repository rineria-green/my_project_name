<?php


namespace App\Controller;


use App\Entity\Poll;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Jsoner;

class PollController extends AbstractController
{
    /**
     * @Route("/api/poll", name="create_poll", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createPoll(Request $request, Jsoner $jsoner)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $content = $request->getContent();
        $content = json_decode($content, true);
        $poll = new Poll();
        $poll->setTitle($content["title"]);
        $this->getDoctrine()->getManager()->persist($poll);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse($jsoner->getJson($poll), 201, [],true);
    }

    /**
     * @Route("/api/poll/{id}", name="show_poll", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function showPoll($id, Jsoner $jsoner)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $poll = $this->getDoctrine()->getManager()->getRepository(Poll::class)->find($id);
        return new JsonResponse($jsoner->getJson($poll), 200, [],true);
    }

    /**
     * @Route("/api/poll/{id}", name="delete_poll", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deletePoll($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $poll = $this->getDoctrine()->getManager()->getRepository(Poll::class)->find($id);
        $this->getDoctrine()->getManager()->remove($poll);
        $this->getDoctrine()->getManager()->flush();
        return (new Response("",204));
    }
}