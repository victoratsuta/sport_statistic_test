<?php


namespace App\Repository;


use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class BasicRepository extends DocumentRepository
{
    public function getRandomItem()
    {

        $qb = $this->createQueryBuilder();
        $count = count($qb->getQuery()->execute()->toArray());
        $skip_count = random_int(0, $count - 1);
        $qb->skip($skip_count);

        return $qb->getQuery()->getSingleResult();

    }


    public function getByKey(string $key)
    {
        return $this
            ->findOneBy(['key' => $key]);
    }

    public function getRandomBySport(string $sportId)
    {
        $qb = $this->createQueryBuilder()->field('sport')->equals($sportId);
        $count = count($qb->getQuery()->execute()->toArray());
        $skip_count = random_int(0, $count - 1);
        $qb->skip($skip_count);

        return $qb->getQuery()->getSingleResult();

    }

    public function findByNames($name)
    {
        return $this->findOneBy(['names' => $name]);
    }
}