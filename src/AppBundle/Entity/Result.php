<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Result
 *
 * @ORM\Table(name="result")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultRepository")
 */
class Result
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
     * @var Game
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Game", inversedBy="results")
     * @Assert\NotNull()
     */
    private $game;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     * @Assert\NotNull()
     */
    private $player;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     * @Assert\GreaterThan(0)
     */
    private $position;

    /**
     * @var int
     *
     * @ORM\Column(name="winnings", type="float")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $winnings = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="no_of_rebuys", type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $noOfRebuys = 0;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var float|null
     * @ORM\Column(type="float", nullable=true)
     */
    private $leaguePoints;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Result
     */
    public function setId(int $id): Result
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Game
     */
    public function getGame(): ?Game
    {
        return $this->game;
    }

    /**
     * @param Game $game
     * @return Result
     */
    public function setGame(Game $game = null): Result
    {
        $this->game = $game;
        return $this;
    }

    /**
     * @return Player
     */
    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     * @return Result
     */
    public function setPlayer(Player $player): Result
    {
        $this->player = $player;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return Result
     */
    public function setPosition(int $position): Result
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return int
     */
    public function getWinnings(): ?int
    {
        return $this->winnings;
    }

    /**
     * @param int $winnings
     * @return Result
     */
    public function setWinnings(int $winnings): Result
    {
        $this->winnings = $winnings;
        return $this;
    }

    /**
     * @return int
     */
    public function getNoOfRebuys(): ?int
    {
        return $this->noOfRebuys;
    }

    /**
     * @param int $noOfRebuys
     * @return Result
     */
    public function setNoOfRebuys(int $noOfRebuys): Result
    {
        $this->noOfRebuys = $noOfRebuys;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getNet(): int
    {
        return $this->winnings - ($this->getNoOfRebuys() + 1) * $this->getGame()->getBuyIn();
    }

    /**
     * @return float|null
     */
    public function getLeaguePoints(): ?float
    {
        return $this->leaguePoints;
    }

    /**
     * @param float|null $leaguePoints
     * @return Result
     */
    public function setLeaguePoints(float $leaguePoints = null): Result
    {
        $this->leaguePoints = $leaguePoints;
        return $this;
    }
}

