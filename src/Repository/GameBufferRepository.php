<?php

namespace App\Repository;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class GameBufferRepository extends DocumentRepository
{
    public function getByGameId(string $gameId){

        return $this
            ->createQueryBuilder()
            ->field('game')
            ->equals($gameId)
            ->getQuery()
            ->toArray();

    }
}