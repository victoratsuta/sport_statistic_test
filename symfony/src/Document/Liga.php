<?php

namespace App\Document;

use App\Document\Traits\DocumentSerializer;
use App\Repository\LigaRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * @MongoDB\Document(repositoryClass=LigaRepository::class)
 */
class Liga implements BaseDocument
{
    use DocumentSerializer;

    const UEFA = 'uefa';
    const SUPER_LIGA = 'superLiga';
    const NY = 'NY';
    const SV = 'SV';

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
     * @ReferenceOne(targetDocument=Sport::class, storeAs="id", name="sport")
     */
    protected $sport;

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