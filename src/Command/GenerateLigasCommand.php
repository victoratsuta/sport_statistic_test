<?php

namespace App\Command;

use App\Document\Liga;
use App\Document\Sport;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateLigasCommand extends Command
{

    protected static $defaultName = 'app:generate-lig';
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
                    "key" => Liga::UEFA,
                    "sport" => $this->dm->getRepository(Sport::class)->getByKey(Sport::FOOTBALL),
                    "names" => [
                        "UEFA",
                        "liga Uefa",
                    ]
                ],
                [
                    "key" => Liga::SUPER_LIGA,
                    "sport" => $this->dm->getRepository(Sport::class)->getByKey(Sport::FOOTBALL),
                    "names" => [
                        "super super Liga",
                        "LIGASUPER",
                    ]
                ],
                [
                    "key" => Liga::NY,
                    "sport" => $this->dm->getRepository(Sport::class)->getByKey(Sport::BASEBALL),
                    "names" => [
                        "new york",
                        "ny",
                    ]
                ],
                [
                    "key" => Liga::SV,
                    "sport" => $this->dm->getRepository(Sport::class)->getByKey(Sport::BASEBALL),
                    "names" => [
                        "SV",
                        "sv",
                    ]
                ],

            ];

            foreach ($items as $value) {

                $model = new Liga();
                $model->setKey($value['key']);
                $model->setNames($value['names']);
                $model->setSport($value['sport']);
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