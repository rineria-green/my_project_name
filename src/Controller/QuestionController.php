<?php


namespace App\Controller;


use App\Entity\Poll;
use App\Entity\Question;
use App\Service\Jsoner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/api/question", name="create_question", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createQuestion (Request $request, Jsoner $jsoner)
    {
        $content = $request->getContent();
        $content = json_decode($content, true);
        $question = new Question();
        /**
         * @var Poll $poll
         */
        $poll = $this->getDoctrine()->getManager()->getRepository(Poll::class)->find($content["poll"]);
        $question->setPoll($poll);
        $question->setText($content["text"]);
        $this->getDoctrine()->getManager()->persist($question);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse($jsoner->getJson($question), 201, [],true);
    }

    /**
     * @Route("/api/question/{id}", name="delete_question", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deleteQuestion($id)
    {
        $question = $this->getDoctrine()->getManager()->getRepository(Question::class)->find($id);
        $this->getDoctrine()->getManager()->remove($question);
        $this->getDoctrine()->getManager()->flush();
        return (new Response("",204));
    }
}