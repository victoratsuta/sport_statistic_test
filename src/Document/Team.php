<?php

namespace App\Document;

use App\Document\Traits\DocumentSerializer;
use App\Repository\TeamRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * @MongoDB\Document(repositoryClass=TeamRepository::class)
 */
class Team implements BaseDocument
{
    use DocumentSerializer;

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @ReferenceOne(targetDocument=Sport::class, storeAs="id", name="sport")
     */
    protected $sport;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $names;

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
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * @param mixed $sport
     */
    public function setSport($sport): void
    {
        $this->sport = $sport;
    }
}