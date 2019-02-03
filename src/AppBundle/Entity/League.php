<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LeagueRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class League
{

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $buyIn = 0;

    /**
     * @var Collection|Player[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Player", inversedBy="leagues")
     */
    private $players;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $firstPrize = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $secondPrize = 0;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $thirdPrize;

    /**
     * @var Player|null
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     */
    private $firstPlace;

    /**
     * @var Player|null
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     */
    private $secondPlace;

    /**
     * @var Player|null
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     */
    private $thirdPlace;

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

    public function __construct()
    {
        $this->createdAt = $this->updatedAt = new \DateTime();
        $this->startDate = new \DateTime();
        $this->players = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     * @return League
     */
    public function setStartDate(\DateTime $startDate): League
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }



    /**
     * @param \DateTime $endDate
     * @return League
     */
    public function setEndDate(?\DateTime $endDate): League
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getFirstPrize(): int
    {
        return $this->firstPrize;
    }

    /**
     * @param int $firstPrize
     * @return League
     */
    public function setFirstPrize(int $firstPrize): League
    {
        $this->firstPrize = $firstPrize;
        return $this;
    }

    /**
     * @return int
     */
    public function getSecondPrize(): int
    {
        return $this->secondPrize;
    }

    /**
     * @param int $secondPrize
     * @return League
     */
    public function setSecondPrize(int $secondPrize): League
    {
        $this->secondPrize = $secondPrize;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getThirdPrize(): ?int
    {
        return $this->thirdPrize;
    }

    /**
     * @param int|null $thirdPrize
     * @return League
     */
    public function setThirdPrize(?int $thirdPrize): League
    {
        $this->thirdPrize = $thirdPrize;
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
     * @return int
     */
    public function getBuyIn(): int
    {
        return $this->buyIn;
    }

    /**
     * @param int $buyIn
     */
    public function setBuyIn(int $buyIn): void
    {
        $this->buyIn = $buyIn;
    }

    /**
     * @return Player[]|Collection
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): void
    {
        $player->addLeague($this);
        $this->players[] = $player;
    }

    public function removePlayer(Player $player): void
    {
        $this->players->removeElement($player);
    }

    /**
     * @param Player[]|Collection $players
     */
    public function setPlayers($players): void
    {
        $this->players = $players;
    }

    public function getNoOfPlayers(): int
    {
        return $this->getPlayers()->count();
    }

    /**
     * @return Player|null
     */
    public function getFirstPlace(): ?Player
    {
        return $this->firstPlace;
    }

    /**
     * @param Player|null $firstPlace
     * @return League
     */
    public function setFirstPlace(?Player $firstPlace): League
    {
        $this->firstPlace = $firstPlace;
        return $this;
    }

    /**
     * @return Player|null
     */
    public function getSecondPlace(): ?Player
    {
        return $this->secondPlace;
    }

    /**
     * @param Player|null $secondPlace
     * @return League
     */
    public function setSecondPlace(?Player $secondPlace): League
    {
        $this->secondPlace = $secondPlace;
        return $this;
    }

    /**
     * @return Player|null
     */
    public function getThirdPlace(): ?Player
    {
        return $this->thirdPlace;
    }

    /**
     * @param Player|null $thirdPlace
     * @return League
     */
    public function setThirdPlace(?Player $thirdPlace): League
    {
        $this->thirdPlace = $thirdPlace;
        return $this;
    }

}

