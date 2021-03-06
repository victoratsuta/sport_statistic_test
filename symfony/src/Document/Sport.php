<?php

namespace App\Document;

use App\Document\Traits\DocumentSerializer;
use App\Repository\SportRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass=SportRepository::class)
 */
class Sport implements BaseDocument
{
    use DocumentSerializer;

    const FOOTBALL = 'football';
    const BASEBALL = 'baseball';

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $key;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $names;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key): void
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @param mixed $names
     */
    public function setNames($names): void
    {
        $this->names = $names;
    }
}