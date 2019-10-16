<?php

namespace App\Document;

use App\Document\Traits\DocumentSerializer;
use App\Document\Traits\GameStructure;
use App\Repository\GameRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass=GameRepository::class)
 */
class Game implements BaseDocument
{
    use GameStructure;
    use DocumentSerializer;

    protected $gameBufferCount;

    /**
     * @return mixed
     */
    public function getGameBufferCount()
    {
        return $this->gameBufferCount;
    }

    /**
     * @param mixed $gameBufferCount
     */
    public function setGameBufferCount($gameBufferCount): void
    {
        $this->gameBufferCount = $gameBufferCount;
    }

}