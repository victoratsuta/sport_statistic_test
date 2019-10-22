<?php

namespace App\Repository;


use App\Document\GameBuffer;
use DateInterval;
use DateTime;
use MongoDB\BSON\ObjectID as ObjectIDAlias;

class GameRepository extends BasicRepository
{
    public function getByFiltersRandomValue(array $values)
    {

        $qb = $this
            ->createQueryBuilder();

        if ($values['source']) {
            $qb->field('source')->equals($values['source']);
        }

        if ($values['from']) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $values['from']);
            $qb->field('start_time')->gte($date);
        }

        if ($values['to']) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $values['to']);
            $qb->field('start_time')->lte($date);
        }

        $count = count($qb->getQuery()->execute()->toArray());
        $skip_count = $count ? random_int(0, $count - 1) : 0;
        $qb->skip($skip_count);

        return $qb->getQuery()->getSingleResult();
    }

    public function getGameAlreadyExist(GameBuffer $gameBuffer)
    {

        $date = clone $gameBuffer->getStartTime();
        $gte = clone $date->sub(new DateInterval('PT26H'));
        $lte = clone $date->add(new DateInterval('PT52H'));

        return $this
            ->createQueryBuilder()
            ->field('liga')->equals(new ObjectIDAlias($gameBuffer->getLiga()->getId()))
            ->field('team_first')->equals(new ObjectIDAlias($gameBuffer->getTeamFirst()->getId()))
            ->field('team_second')->equals(new ObjectIDAlias($gameBuffer->getTeamSecond()->getId()))
            ->field('start_time')->gte($gte)
            ->field('start_time')->lt($lte)
            ->getQuery()
            ->getSingleResult();
    }
}