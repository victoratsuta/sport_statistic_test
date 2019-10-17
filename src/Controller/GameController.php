<?php

namespace App\Controller;

use App\DataAdapters\GameAdapter;
use App\Document\BaseDocument;
use App\Document\Game;
use App\Document\GameBuffer;
use App\Entity\Movie;
use App\Form\MovieType;
use App\Services\GameSaver;
use App\Validator\GetGameValidator;
use App\Validator\SetGameValidator;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api", name="api_")
 */
class GameController extends AbstractFOSRestController
{

    /**
     * @var DocumentManager
     */
    private $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

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
            return $this->handleView($this->view($violations, 403));
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
     */
    public function postGameAction(Request $request)
    {

        $violations = (new SetGameValidator($request))->validate();

        if (count($violations)) {
            return $this->handleView($this->view($violations, 403));
        }

        $data = $request->request->get('data');
        $games = SetGameValidator::isAssoc($data) ? [$data] : $data;

        try {
            (new GameSaver($games, $this->dm))->save();
        } catch (Exception $e) {
            return $this->handleView($this->view($e->getMessage(), 500));
        }

        return $this->handleView($this->view([]));

    }


}