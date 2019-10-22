<?php

namespace App\Command;

use App\Document\Game;
use App\Document\GameBuffer;
use App\Document\Language;
use App\Document\Liga;
use App\Document\Sport;
use App\Document\Team;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;
use MongoDB\BSON\ObjectID;
use MongoDB\BSON\UTCDateTime as UTCDateTimeAlias;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateGamesCommand extends Command
{

    protected static $defaultName = 'app:generate-games';
    /**
     * @var DocumentManager
     */
    private $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {

            $items = [];


            for ($i = 0; $i < 15; $i++) {

                $sports = [Sport::FOOTBALL, Sport::BASEBALL];
                $sportKey = $sports[array_rand($sports)];

                $sport = $this->dm->getRepository(Sport::class)->getByKey($sportKey);
                $language = $this->dm->getRepository(Language::class)->getByKey(Language::EN);
                $liga = $this->dm->getRepository(Liga::class)->getRandomBySport($sport->getId());
                $teamFirst = $this->dm->getRepository(Team::class)->getRandomBySport($sport->getId());
                $teamSecond = $this->dm->getRepository(Team::class)->getRandomBySport($sport->getId());


                $time = new UTCDateTimeAlias();

                $items[] = [
                    "sport" => $sport,
                    "language" => $language,
                    "liga" => $liga,
                    "team_first" => $teamFirst,
                    "team_second" => $teamSecond,
                    "start_time" => $time,
                    "source" => "facebook",
                    "game_buffer" => [
                        [
                            "sport" => $sport,
                            "language" => $language,
                            "liga" => $liga,
                            "team_first" => $teamFirst,
                            "team_second" => $teamSecond,
                            "start_time" => $time,
                            "source" => "youtube",
                        ],
                        [
                            "sport" => $sport,
                            "language" => $language,
                            "liga" => $liga,
                            "team_first" => $teamFirst,
                            "team_second" => $teamSecond,
                            "start_time" => $time,
                            "source" => "twitter",
                        ],
                        [
                            "sport" => $sport,
                            "language" => $language,
                            "liga" => $liga,
                            "team_first" => $teamFirst,
                            "team_second" => $teamSecond,
                            "start_time" => $time,
                            "source" => "facebook",
                        ],
                    ]
                ];
            }

            foreach ($items as $value) {

                $id = new ObjectID();

                $model = new Game();
                $model->setId($id);
                $model->setSport($value['sport']);
                $model->setLanguage($value['language']);
                $model->setLiga($value['liga']);
                $model->setTeamFirst($value['team_first']);
                $model->setTeamSecond($value['team_second']);
                $model->setStartTime($value['start_time']);
                $model->setSource($value['source']);
                $this->dm->persist($model);
                $this->dm->flush();

                foreach ($value['game_buffer'] as $gameBuffer) {

                    $model = new GameBuffer();
                    $model->setSport($gameBuffer['sport']);
                    $model->setLanguage($gameBuffer['language']);
                    $model->setLiga($gameBuffer['liga']);
                    $model->setTeamFirst($gameBuffer['team_first']);
                    $model->setTeamSecond($gameBuffer['team_second']);
                    $model->setStartTime($gameBuffer['start_time']);
                    $model->setSource($gameBuffer['source']);
                    $model->setGame($this->dm->getRepository(Game::class)->find($id));

                    $this->dm->persist($model);
                    $this->dm->flush();
                }

            }


        } catch (Exception $e) {
            $output->writeln('Some error');
            $output->writeln($e->getMessage());
            return;
        }

        $output->writeln('Finish');
    }
}