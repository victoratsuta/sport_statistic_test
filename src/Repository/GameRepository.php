<?php

namespace App\Repository;


use DateTime;

class GameRepository extends BasicRepository
{
    public function getByFiltersRandomValue(array $values){

        $qb = $this
            ->createQueryBuilder();

        if($values['source']){
            $qb->field('source')->equals($values['source']);
        }

        if($values['from']){
            $date = DateTime::createFromFormat('Y-m-d', $values['from']);
            $qb->field('start_time')->gte($date);
        }

        if($values['to']){
            $date = DateTime::createFromFormat('Y-m-d', $values['to']);
            $qb->field('start_time')->lte($date);
        }

        $count = count($qb->getQuery()->execute()->toArray());
        $skip_count = $count ? random_int(0, $count-1): 0;
        $qb->skip($skip_count);

        return $qb->getQuery()->getSingleResult();
    }
}