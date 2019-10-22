<?php

namespace App\Document\Traits;

use App\Document\Language;
use App\Document\Liga;
use App\Document\Sport;
use App\Document\Team;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

trait GameStructure
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @ReferenceOne(targetDocument=Language::class, storeAs="id", name="language")
     */
    protected $language;

    /**
     * @ReferenceOne(targetDocument=Sport::class, storeAs="id", name="sport")
     */
    protected $sport;

    /**
     * @ReferenceOne(targetDocument=Liga::class, storeAs="id", name="liga")
     */
    protected $liga;

    /**
     * @ReferenceOne(targetDocument=Team::class, storeAs="id", name="team_first")
     */
    protected $teamFirst;

    /**
     * @ReferenceOne(targetDocument=Team::class, storeAs="id", name="team_second")
     */
    protected $teamSecond;

    /**
     * @MongoDB\Field(type="date", name="start_time")
     */
    protected $startTime;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $source;

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language): void
    {
        $this->language = $language;
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

    /**
     * @return mixed
     */
    public function getLiga()
    {
        return $this->liga;
    }

    /**
     * @param mixed $liga
     */
    public function setLiga($liga): void
    {
        $this->liga = $liga;
    }

    /**
     * @return mixed
     */
    public function getTeamFirst()
    {
        return $this->teamFirst;
    }

    /**
     * @param mixed $teamFirst
     */
    public function setTeamFirst($teamFirst): void
    {
        $this->teamFirst = $teamFirst;
    }

    /**
     * @return mixed
     */
    public function getTeamSecond()
    {
        return $this->teamSecond;
    }

    /**
     * @param mixed $teamSecond
     */
    public function setTeamSecond($teamSecond): void
    {
        $this->teamSecond = $teamSecond;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source): void
    {
        $this->source = $source;
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