<?php

namespace App\Command;

use App\Document\Liga;
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
                "uefa" => [
                    "UEFA",
                    "liga Uefa",
                ],
                "superLiga" => [
                    "super super Liga",
                    "LIGASUPER",
                    "FR"
                ]

            ];

            foreach ($items as $key => $possibleValues) {

                $model = new Liga();
                $model->setKey($key);
                $model->setNames($possibleValues);
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