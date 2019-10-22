<?php

namespace App\Command;

use App\Document\Language;
use Doctrine\ODM\MongoDB\DocumentManager;
use Exception;
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
                Language::EN => [
                    "en",
                    "ENG",
                    "EN"
                ],
                Language::FR => [
                    "fr",
                    "FRANCE",
                    "FR"
                ],
                Language::GR => [
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


        } catch (Exception $e) {
            $output->writeln('Some error');
            $output->writeln($e->getMessage());
            return;
        }

        $output->writeln('Finish');
    }
}