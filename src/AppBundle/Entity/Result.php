<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Result
 *
 * @ORM\Table(name="result")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Player",
     *     inversedBy="results"
     * )
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
    private $winnings;

    /**
     * @var int
     *
     * @ORM\Column(name="no_of_rebuys", type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $noOfRebuys;

    /**
     * @var int
     *
     * @ORM\Column(type="float", options={"default" : 0})
     * @Assert\GreaterThanOrEqual(0)
     */
    private $addOn;

    /**
     * @var int
     *
     * @ORM\Column(type="float", options={"default" : 0})
     * @Assert\GreaterThanOrEqual(0)
     */
    private $topUp;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @var float|null
     * @ORM\Column(type="float", nullable=true)
     */
    private $leaguePoints;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isLeaguePlayer;

    public function __construct()
    {
        $this->winnings = $this->noOfRebuys = $this->addOn = $this->topUp = 0;
        $this->createdAt = $this->updatedAt = new \DateTime();
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
    public function setPlayer(Player $player = null): Result
    {
        $this->player = $player;
        $player->addResult($this);
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
        return $this->winnings - $this->getBoughtIn();
    }

    /**
     * @return int
     */
    public function getBoughtIn(): int
    {
        return ($this->noOfRebuys + 1) * $this->getGame()->getBuyIn() + $this->addOn + $this->topUp;
    }

    /**
     * @return int
     */
    public function getAddOn(): int
    {
        return $this->addOn;
    }

    /**
     * @param int $addOn
     * @return Result
     */
    public function setAddOn(int $addOn): Result
    {
        $this->addOn = $addOn;
        return $this;
    }

    /**
     * @return int
     */
    public function getTopUp(): int
    {
        return $this->topUp;
    }

    /**
     * @param int $topUp
     * @return Result
     */
    public function setTopUp(int $topUp): Result
    {
        $this->topUp = $topUp;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLeaguePoints(): ?float
    {
        $noOfPlayersInGame = $this->getGame()->getNoOfPlayers();
        if ($noOfPlayersInGame === null) {
            return 0;
        }
        $leaguePoints = $this->getGame()->getNoOfPlayers() - $this->getPosition();
        if ($this->getPosition() === 1) {
            $leaguePoints++; // Bonus point
        }
        return $leaguePoints;
    }

    /**
     * @deprecated just compute directly
     * @param float|null $leaguePoints
     * @return Result
     */
    public function setLeaguePoints(float $leaguePoints = null): Result
    {
        $this->leaguePoints = $leaguePoints;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @link http://www.homepokertourney.com/poker-league-points-systems.htm
     * @return float|null
     */
    public function getGeneralPoints(): ?float
    {
        $noOfPlayersInGame = $this->getGame()->getNoOfPlayers();
        if ($noOfPlayersInGame === null) {
            return 0;
        }
        $buyIn = $this->getGame()->getBuyIn();
        $boughtIn = $this->getBoughtIn();
        $position = $this->position;
        return sqrt($noOfPlayersInGame * $buyIn * $buyIn / $boughtIn) /
            ($position + 1);
    }

    public function isLeaguePlayer(): ?bool
    {
        return $this->isLeaguePlayer;
    }

    /**
     * @ORM\PreFlush()
     */
    public function updateLeaguePlayer(): void
    {
        $game = $this->getGame();
        if ($game === null) {
            $this->isLeaguePlayer = null;
            return;
        }

        if ($game->isLeague() === false) {
            $this->isLeaguePlayer = null;
            return;
        }

        if ($this->getPlayer() === null) {
            $this->isLeaguePlayer = null;
            return;
        }

        $this->isLeaguePlayer = $this->getPlayer()->getLeagues()->filter(function (League $league) use ($game) {
            return $league->getStartDate() < $game->getDate()
                && ($league->getEndDate() === null || $league->getEndDate() >= $game->getDate());
        })->count();
    }
}

