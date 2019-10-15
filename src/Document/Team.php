<?php

namespace App\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Team
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string", name="sport_id")
     */
    protected $sportId;

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
    public function getSportId()
    {
        return $this->sportId;
    }

    /**
     * @param mixed $sportId
     */
    public function setSportId($sportId): void
    {
        $this->sportId = $sportId;
    }
}