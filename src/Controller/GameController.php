<?php

namespace App\Controller;

use App\DataAdapters\GameAdapter;
use App\Document\BaseDocument;
use App\Document\Game;
use App\Document\GameBuffer;
use App\Document\Sport;
use App\Entity\Movie;
use App\Form\MovieType;
use App\Validator\GetGameValidator;
use Doctrine\ODM\MongoDB\DocumentManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api", name="api_")
 */
class GameController extends FOSRestController
{
    /**
     * @Rest\Get("/game")
     *
     * @param Request $request
     * @param DocumentManager $dm
     * @return Response
     */
    public function getGameAction(Request $request, DocumentManager $dm)
    {
        $violations = (new GetGameValidator($request))->validate();

        if(count($violations)){
            return $this->handleView($this->view($violations));
        }

        $randomGame = $dm->getRepository(Game::class)->getByFiltersRandomValue([
            "source" => $request->query->get('source'),
            "from" => $request->query->get('from'),
            "to" => $request->query->get('to'),
        ]);

        if($randomGame){
            $gameBuffers = $dm->getRepository(GameBuffer::class)->getByGameId($randomGame->getId());
            $randomGame->setGameBufferCount(count($gameBuffers));
        }

        $result = $randomGame instanceof BaseDocument ? $randomGame->toArray() : [];

        return $this->handleView($this->view($result));
    }

    /**
     * @Rest\Post("/game")
     * @return Response
     */
    public function postGameAction(Request $request)
    {
//        $movie = new Movie();
//        $form = $this->createForm(MovieType::class, $movie);
//        $data = json_decode($request->getContent(), true);
//        $form->submit($data);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($movie);
//            $em->flush();
//            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
//        }

        // check array or item and set validation

        $games = [];

        foreach ($games as $game) {

            // save to game_buffer if this first one
            // create object for searching in game
            // resolve time question
            // create new or merge

        }

        // send 200 or 500

        return [];

//        return $this->handleView($this->view($form->getErrors()));
    }


}