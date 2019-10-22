<?php

namespace App\Document;

use App\Document\Traits\DocumentSerializer;
use App\Document\Traits\GameStructure;
use App\Repository\GameBufferRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use App\Document\Game;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * @MongoDB\Document(repositoryClass=GameBufferRepository::class)
 */
class GameBuffer implements BaseDocument
{
    use GameStructure;
    use DocumentSerializer;
    /**
     * @ReferenceOne(targetDocument=Game::class, storeAs="id", name="game")
     */
    protected $game;

    /**
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param mixed $game
     */
    public function setGame($game): void
    {
        $this->game = $game;
    }


}