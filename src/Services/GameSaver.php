<?php

namespace App\Services;

use App\Document\Game;
use App\Document\GameBuffer;
use App\Document\Language;
use App\Document\Liga;
use App\Document\Sport;
use App\Document\Team;
use DateTime;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;

class GameSaver
{
    private $games;
    /**
     * @var DocumentManager
     */
    private $dm;

    /**
     * GameSaver constructor.
     * @param array $games
     * @param DocumentManager $dm
     */
    public function __construct(array $games, DocumentManager $dm)
    {
        $this->games = $games;
        $this->dm = $dm;
    }

    public function save()
    {

        foreach ($this->games as $gameFromApi) {

            $formattedGameFromApi = $this->formatDataFromApi($gameFromApi);

            $gameBuffer = $this->dm->getRepository(GameBuffer::class)->getGameBufferAlreadyExist($formattedGameFromApi);

            if (!$gameBuffer) {

                $gameBuffer = new GameBuffer();
                $gameBuffer->setSport($formattedGameFromApi['sport']);
                $gameBuffer->setLanguage($formattedGameFromApi['language']);
                $gameBuffer->setLiga($formattedGameFromApi['liga']);
                $gameBuffer->setTeamFirst($formattedGameFromApi['team_first']);
                $gameBuffer->setTeamSecond($formattedGameFromApi['team_second']);
                $gameBuffer->setStartTime($formattedGameFromApi['start_time']);
                $gameBuffer->setSource($formattedGameFromApi['source']);

                $this->dm->persist($gameBuffer);
                $this->dm->flush();
            }

            $game = $this->dm->getRepository(Game::class)->getGameAlreadyExist($gameBuffer);

//            print_r($game->getId());exit();

            if (!$game) {

                $game = new Game();
                $game->setSport($gameBuffer->getSport());
                $game->setLanguage($gameBuffer->getLanguage());
                $game->setLiga($gameBuffer->getLiga());
                $game->setTeamFirst($gameBuffer->getTeamFirst());
                $game->setTeamSecond($gameBuffer->getTeamSecond());

            }

            $game->setStartTime($gameBuffer->getStartTime());
            $game->setSource($gameBuffer->getSource());

            $this->dm->persist($game);
            $this->dm->flush();

            $gameBuffer->setGame($game);

            $this->dm->persist($gameBuffer);
            $this->dm->flush();

        }

    }

    public function formatDataFromApi($data)
    {

        $startTime = DateTime::createFromFormat('Y-m-d H:i:s', $data['start_time']);

        $fields = [
            "sport" => Sport::class,
            "language" => Language::class,
            "liga" => Liga::class,
            "team_first" => Team::class,
            "team_second" => Team::class
        ];

        foreach ($fields as $field => &$container) {
            $container = $this->dm->getRepository($container)->findByNames($data[$field]);

            if (!$container) {
                throw new Exception("No " . $field . " was found with name " . $data[$field]);
            }

        }

        return [
            "sport" => $fields["sport"],
            "language" => $fields["language"],
            "liga" => $fields["liga"],
            "team_first" => $fields["team_first"],
            "team_second" => $fields["team_second"],
            "start_time" => $startTime,
            "source" => $data['source']
        ];

    }
}