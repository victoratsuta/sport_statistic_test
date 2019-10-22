<?php

namespace App\Repository;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use MongoDB\BSON\ObjectId as ObjectIDAlias;

class GameBufferRepository extends DocumentRepository
{
    public function getByGameId(string $gameId)
    {

        return $this
            ->createQueryBuilder()
            ->field('game')
            ->equals($gameId)
            ->getQuery()
            ->toArray();

    }

    public function getGameBufferAlreadyExist(array $data)
    {
        return $this
            ->createQueryBuilder()
            ->field('sport')->equals(new ObjectIDAlias($data["sport"]->getId()))
            ->field('language')->equals(new ObjectIDAlias($data["language"]->getId()))
            ->field('liga')->equals(new ObjectIDAlias($data["liga"]->getId()))
            ->field('team_first')->equals(new ObjectIDAlias($data["team_first"]->getId()))
            ->field('team_second')->equals(new ObjectIDAlias($data["team_second"]->getId()))
            ->field('start_time')->equals($data["start_time"])
            ->field('source')->equals($data["source"])
            ->getQuery()
            ->getSingleResult();
    }
}