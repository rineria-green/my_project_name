<?php


namespace App\Controller;


use App\Entity\Answer;
use App\Entity\User;
use App\Entity\Question;
use App\Service\Jsoner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
    /**
     * @Route("/api/answer", name="create_answer", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createAnswer(Request $request, Jsoner $jsoner)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $content = $request->getContent();
        $content = json_decode($content, true);
        $answer = new Answer();
        $question = $this->getDoctrine()->getManager()->getRepository(Question::class)->find($content["question"]);
        /**
         * @var Question $question
         */
        $answer->setQuestion($question);
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($content["user"]);
        /**
         * @var User $user
         */
        $answer->setUser($user);
        $answer->setText($content["text"]);
        $this->getDoctrine()->getManager()->persist($answer);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse($jsoner->getJson($answer), 201, [], true);
    }

    /**
     * @Route("/api/answer/{id}", name="delete_answer", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deleteAnswer($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $answer = $this->getDoctrine()->getManager()->getRepository(Answer::class)->find($id);
        $this->getDoctrine()->getManager()->remove($answer);
        $this->getDoctrine()->getManager()->flush();
        return (new Response("", 204));
    }
}