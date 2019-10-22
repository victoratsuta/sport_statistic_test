<?php

namespace App\Tests;

use App\Document\Game;
use App\Document\GameBuffer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Process\Process;

class SetGameTest extends WebTestCase
{

    // checck validation
    // send collection and single item
    // save same gamebuffer, same quantity of gamebuffer should be, and ame quantity of game
    // save same gamebuffer but with different source, new gamebuffer, old game should change source
    // save same gamebuffer with diferent +-26h date, old game should change date
    // save same gamebuffer with diferent +-50h date, new game

    private $dm;

    public function testValidationWrong()
    {

        $client = static::createClient();
        $client->request('POST', '/api/game');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

    }

    public function testValidationWright()
    {
        $client = static::createClient();
        $client->request('POST', '/api/game', [
            "data" => [
                "language" => "en",
                "sport" => "footbal",
                "liga" => "liga Uefa",
                "team_first" => "milan",
                "team_second" => "BARCA",
                "start_time" => "2019-07-10 22:00:00",
                "source" => "ytoutube.com",
            ]
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testSaveItemWithUnexistingLiga()
    {

        $client = static::createClient();
        $client->request('POST', '/api/game', [
            "data" => [
                "language" => "en",
                "sport" => "footbal",
                "liga" => "liga SUPER Uefa",
                "team_first" => "milan",
                "team_second" => "BARCA",
                "start_time" => "2019-07-10 22:00:00",
                "source" => "ytoutube.com",
            ]
        ]);
        $this->assertEquals(500, $client->getResponse()->getStatusCode());

    }

    public function testCollectionsSend()
    {

        $client = static::createClient();
        $client->request('POST', '/api/game', [
            "data" => [
                [
                    "language" => "en",
                    "sport" => "footbal",
                    "liga" => "liga Uefa",
                    "team_first" => "milan",
                    "team_second" => "BARCA",
                    "start_time" => "2019-07-10 22:00:00",
                    "source" => "ytoutube.com",
                ],
                [
                    "language" => "en",
                    "sport" => "footbal",
                    "liga" => "liga Uefa",
                    "team_first" => "milan",
                    "team_second" => "BARCA",
                    "start_time" => "2019-07-10 22:00:00",
                    "source" => "ytoutube.com",
                ], [
                    "language" => "en",
                    "sport" => "footbal",
                    "liga" => "liga Uefa",
                    "team_first" => "milan",
                    "team_second" => "BARCA",
                    "start_time" => "2019-07-10 22:00:00",
                    "source" => "ytoutube.com",
                ]
            ]
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function testSaveSameGame()
    {

        $client = static::createClient();
        $client->request('POST', '/api/game', [
            "data" => [
                "language" => "en",
                "sport" => "footbal",
                "liga" => "liga Uefa",
                "team_first" => "milan",
                "team_second" => "BARCA",
                "start_time" => "2019-07-10 22:00:00",
                "source" => "ytoutube.com",
            ]
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $gameCountBefore = $this->dm->getRepository(Game::class)->createQueryBuilder()->count()->getQuery()->execute();
        $gameBufferCountBefore = $this->dm->getRepository(GameBuffer::class)->createQueryBuilder()->count()->getQuery()->execute();

        $client->request('POST', '/api/game', [
            "data" => [
                "language" => "en",
                "sport" => "footbal",
                "liga" => "liga Uefa",
                "team_first" => "milan",
                "team_second" => "BARCA",
                "start_time" => "2019-07-10 22:00:00",
                "source" => "ytoutube.com",
            ]
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $gameCountAfter = $this->dm->getRepository(Game::class)->createQueryBuilder()->count()->getQuery()->execute();
        $gameBufferCountAfter = $this->dm->getRepository(GameBuffer::class)->createQueryBuilder()->count()->getQuery()->execute();

        $this->assertEquals($gameCountBefore, $gameCountAfter);
        $this->assertEquals($gameBufferCountBefore, $gameBufferCountAfter);


    }

    public function testSaveSameGameWithDifferentSource()
    {
        $client = static::createClient();
        $client->request('POST', '/api/game', [
            "data" => [
                "language" => "en",
                "sport" => "footbal",
                "liga" => "liga Uefa",
                "team_first" => "milan",
                "team_second" => "BARCA",
                "start_time" => "2019-07-10 22:00:00",
                "source" => "ytoutube.com",
            ]
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $gameCountBefore = $this->dm->getRepository(Game::class)->createQueryBuilder()->count()->getQuery()->execute();
        $gameBufferCountBefore = $this->dm->getRepository(GameBuffer::class)->createQueryBuilder()->count()->getQuery()->execute();

        $client->request('POST', '/api/game', [
            "data" => [
                "language" => "en",
                "sport" => "footbal",
                "liga" => "liga Uefa",
                "team_first" => "milan",
                "team_second" => "BARCA",
                "start_time" => "2019-07-10 22:00:00",
                "source" => "facebook",
            ]
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $gameCountAfter = $this->dm->getRepository(Game::class)->createQueryBuilder()->count()->getQuery()->execute();
        $gameBufferCountAfter = $this->dm->getRepository(GameBuffer::class)->createQueryBuilder()->count()->getQuery()->execute();

        $this->assertEquals($gameCountBefore, $gameCountAfter);
        $this->assertEquals($gameBufferCountBefore + 1, $gameBufferCountAfter);
    }

    public function testSaveSameGameWithDifferentAvailableDate()
    {

        $client = static::createClient();
        $client->request('POST', '/api/game', [
            "data" => [
                "language" => "en",
                "sport" => "footbal",
                "liga" => "liga Uefa",
                "team_first" => "milan",
                "team_second" => "BARCA",
                "start_time" => "2019-07-10 22:00:00",
                "source" => "ytoutube.com",
            ]
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $gameCountBefore = $this->dm->getRepository(Game::class)->createQueryBuilder()->count()->getQuery()->execute();
        $gameBufferCountBefore = $this->dm->getRepository(GameBuffer::class)->createQueryBuilder()->count()->getQuery()->execute();;

        $client->request('POST', '/api/game', [
            "data" => [
                "language" => "en",
                "sport" => "footbal",
                "liga" => "liga Uefa",
                "team_first" => "milan",
                "team_second" => "BARCA",
                "start_time" => "2019-07-10 13:00:00",
                "source" => "ytoutube.com",
            ]
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $gameCountAfter = $this->dm->getRepository(Game::class)->createQueryBuilder()->count()->getQuery()->execute();;
        $gameBufferCountAfter = $this->dm->getRepository(GameBuffer::class)->createQueryBuilder()->count()->getQuery()->execute();;

        $this->assertEquals($gameCountBefore, $gameCountAfter);
        $this->assertEquals($gameBufferCountBefore + 1, $gameBufferCountAfter);

    }

    public function testSaveSameGameWithDifferentUnavailableDate()
    {

        $client = static::createClient();
        $client->request('POST', '/api/game', [
            "data" => [
                "language" => "en",
                "sport" => "footbal",
                "liga" => "liga Uefa",
                "team_first" => "milan",
                "team_second" => "BARCA",
                "start_time" => "2019-07-10 22:00:00",
                "source" => "ytoutube.com",
            ]
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $gameCountBefore = $this->dm->getRepository(Game::class)->createQueryBuilder()->count()->getQuery()->execute();;
        $gameBufferCountBefore = $this->dm->getRepository(GameBuffer::class)->createQueryBuilder()->count()->getQuery()->execute();;

        $client->request('POST', '/api/game', [
            "data" => [
                "language" => "en",
                "sport" => "footbal",
                "liga" => "liga Uefa",
                "team_first" => "milan",
                "team_second" => "BARCA",
                "start_time" => "2019-07-12 22:00:00",
                "source" => "ytoutube.com",
            ]
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $gameCountAfter = $this->dm->getRepository(Game::class)->createQueryBuilder()->count()->getQuery()->execute();
        $gameBufferCountAfter = $this->dm->getRepository(GameBuffer::class)->createQueryBuilder()->count()->getQuery()->execute();;

        $this->assertEquals($gameCountBefore + 1, $gameCountAfter);
        $this->assertEquals($gameBufferCountBefore + 1, $gameBufferCountAfter);

    }

    protected function setUp()
    {

        $kernel = self::bootKernel();

        $this->dm = $kernel->getContainer()
            ->get("doctrine_mongodb")
            ->getManager();

        $process = new Process('./setdb.sh');
        $process->run();


    }

}