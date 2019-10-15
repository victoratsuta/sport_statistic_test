<?php

namespace App\Command;

use App\Document\Language;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateLanguagesCommand extends Command
{

    protected static $defaultName = 'app:generate-lang';
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
                "en" => [
                    "en",
                    "ENG",
                    "EN"
                ],
                "fr" => [
                    "fr",
                    "FRANCE",
                    "FR"
                ],
                "gr" => [
                    "gr",
                    "GERM",
                    "GR"
                ],

            ];

            foreach ($items as $key => $possibleValues) {

                $model = new Language();
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