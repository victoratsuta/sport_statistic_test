<?php

namespace App\Repository;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class SportRepository extends DocumentRepository
{
    public function getIdByKey(string $key)
    {
        return $this
            ->findOneBy(['key' => $key])
            ->getId();
    }
}