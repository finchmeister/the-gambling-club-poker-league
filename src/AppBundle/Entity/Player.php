<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Player
 *
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $location;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_league_player", type="boolean")
     */
    private $leaguePlayer = false;

    /**
     * @var Result[]|Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Result", mappedBy="player")
     */
    private $results;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $bio = '';

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->results = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Player
     */
    public function setName(string $name): Player
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return Player
     */
    public function setLocation(string $location): Player
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLeaguePlayer(): bool
    {
        return $this->leaguePlayer;
    }

    /**
     * @param bool $leaguePlayer
     * @return Player
     */
    public function setLeaguePlayer(bool $leaguePlayer): Player
    {
        $this->leaguePlayer = $leaguePlayer;
        return $this;
    }

    /**
     * @return Result[]|Collection
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    /**
     * @param Result $result
     * @return Player
     */
    public function addResult(Result $result): Player
    {
        if (!$this->results->contains($result)) {
            $this->results->add($result);
            $result->setPlayer($this);
        }
        return $this;
    }

    /**
     * @param Result $result
     * @return Player
     */
    public function removeResult(Result $result): Player
    {
        if ($this->results->contains($result)) {
            $this->results->removeElement($result);
            $result->setPlayer(null);
        }
        return $this;
    }


    /**
     * @param Result[]|Collection $results
     * @return Player
     */
    public function setResults(Collection $results): Player
    {
        $this->results = $results;
        return $this;
    }

    /**
     * @return string
     */
    public function getBio(): string
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     * @return Player
     */
    public function setBio(string $bio): Player
    {
        $this->bio = $bio;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}

