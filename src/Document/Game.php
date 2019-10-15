<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Game
{
    /**
     * @MongoDB\Id
     */
    protected $id;


}