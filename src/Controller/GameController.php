<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Movie controller.
 * @Route("/api", name="api_")
 */
class GameController extends FOSRestController
{
    /**
     * @Rest\Get("/game")
     *
     * @return Response
     */
    public function getGameAction()
    {
//        $repository = $this->getDoctrine()->getRepository(Movie::class);
//        $movies = $repository->findall();

        // get filters param

        // fetch data by random game with filtered game_buffer data

//        return object like this
//        {
//            lang: en,
//            ...,
//            game_buffer: {
//              lang: en
//            }
//        }

        $data = [
            "sport" => "footbal",
            "liga" => "UEFA",
            "command_1" => "qwe",
            "command_1" => "asd",
            "start_time" => "12:00",

            "game_buffer" => [
                "lang" => "en",
                "sport" => "footbal",
                "liga" => "UEFA",
                "command_1" => "qwe",
                "command_1" => "asd",
                "start_time" => "12:00",
                "source" => "TV",
                "original_data" => ["data"],
            ],
        ];

        return $this->handleView($this->view($data));
    }

    /**
     * Create Movie.
     * @Rest\Post("/game")
     *
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