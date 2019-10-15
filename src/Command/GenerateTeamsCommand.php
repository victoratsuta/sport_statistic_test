<?php

namespace App\Command;

use App\Document\Sport;
use App\Document\Team;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateTeamsCommand extends Command
{

    protected static $defaultName = 'app:generate-team';
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

            $items = [
                [
                    "sport_id" => $this->dm->getRepository(Sport::class)->getIdByKey(Sport::FOOTBALL),
                    "names" => [
                        "barcelona",
                        "BARCA",
                    ]
                ],
                [
                    "sport_id" => $this->dm->getRepository(Sport::class)->getIdByKey(Sport::BASEBALL),
                    "names" => [
                        "milan",
                        "FC MILAN",
                    ]
                ],
                [
                    "sport_id" => $this->dm->getRepository(Sport::class)->getIdByKey(Sport::FOOTBALL),
                    "names" => [
                        "YANKI",
                        "yankees",
                    ]
                ],

            ];

            foreach ($items as $value) {

                $model = new Team();
                $model->setSportId($value['sport_id']);
                $model->setNames($value['names']);
                $this->dm->persist($model);
                $this->dm->flush();
            }


        } catch (\Exception $e) {
            $output->writeln('Some error');
            $output->writeln($e->getMessage());
            return;
        }

        $output->writeln('Finish');
    }
}