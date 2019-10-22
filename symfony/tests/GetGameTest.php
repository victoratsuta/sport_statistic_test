<?php

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Process\Process;

class GetGameTest extends WebTestCase
{
    // check validation
    // check filters
    // check buffer count

    protected function setUp()
    {

        $kernel = self::bootKernel();

        $this->dm = $kernel->getContainer()
            ->get("doctrine_mongodb")
            ->getManager();

        $process = Process::fromShellCommandline('./bin/setdb.sh');
        $process->run();


    }


    public function testValidationNoFilterParams()
    {

        $client = static::createClient();
        $client->request('GET', '/api/game');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function testValidationWithWrongFilterParams()
    {

        $client = static::createClient();
        $client->request('GET', '/api/game', [
            "source" => 'youtube',
            "from" => '2314124124',
            "to" => '2314124124',
        ]);
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

    }

    public function testValidationWithFilterParams()
    {

        $client = static::createClient();
        $client->request('GET', '/api/game', [
            "source" => 'youtube',
            "from" => '2019-11-12 12:00:00',
            "to" => '2019-11-12 23:00:00',
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function testFiltersNoItem()
    {

        $client = static::createClient();
        $client->request('GET', '/api/game', [
            "source" => 'face',
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(empty(json_decode($client->getResponse()->getContent(), true)));

    }

    public function testFiltersWithItems()
    {

        $client = static::createClient();
        $client->request('GET', '/api/game');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(!empty(json_decode($client->getResponse()->getContent(), true)));

    }

    public function testBufferCount()
    {

        $client = static::createClient();
        $client->request('GET', '/api/game');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertTrue(!empty($response));
        $this->assertArrayHasKey('gameBufferCount', $response);

    }
}