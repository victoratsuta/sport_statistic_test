<?php

namespace App\Document;

use App\Document\Traits\DocumentSerializer;
use App\Repository\LanguageRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass=LanguageRepository::class)
 */
class Language implements BaseDocument
{

    use DocumentSerializer;

    const EN = 'en';
    const FR = 'fr';
    const GR = 'gr';

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
}