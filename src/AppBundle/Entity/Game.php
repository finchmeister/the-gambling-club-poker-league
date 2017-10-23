<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 */
class Game
{
    const DEFAULT_BUY_IN = 10;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     * @Assert\NotBlank()
     */
    private $host;

    /**
     * @var float
     *
     * @ORM\Column(name="buy_in", type="float")
     */
    private $buyIn = self::DEFAULT_BUY_IN;

    /**
     * @var Result[]
     *
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Result",
     *     mappedBy="game",
     *     cascade={"persist"}
     * )
     * @Assert\Valid()
     */
    private $results;

    /**
     * @var bool
     * @ORM\Column(name="is_league", type="boolean")
     */
    private $isLeague = true;

    public function __construct()
    {
        $this->results = new ArrayCollection();
        $this->date = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Game
     */
    public function setDate(\DateTime $date): Game
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return Player
     */
    public function getHost(): ?Player
    {
        return $this->host;
    }

    /**
     * @param Player $host
     * @return Game
     */
    public function setHost(Player $host): Game
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return float
     */
    public function getBuyIn(): float
    {
        return $this->buyIn;
    }

    /**
     * @param float $buyIn
     * @return Game
     */
    public function setBuyIn(float $buyIn): Game
    {
        $this->buyIn = $buyIn;
        return $this;
    }

    /**
     * @return Result[]|Collection
     */
    public function getResults(): ?Collection
    {
        return $this->results;
    }

    /**
     * @param Result[] $results
     * @return Game
     */
    public function setResults(array $results): Game
    {
        $this->results = $results;
        return $this;
    }

    /**
     * @param Result $result
     * @return Game
     */
    public function addResult(Result $result): Game
    {
        $this->results->add($result);
        $result->setGame($this);
        return $this;
    }

    /**
     * @param Result $result
     * @return Game
     */
    public function removeResult(Result $result): Game
    {
        $this->results->removeElement($result);
        $result->setGame(null);
        return $this;
    }

    /**
     * @return bool
     */
    public function isLeague(): bool
    {
        return $this->isLeague;
    }

    /**
     * @param bool $isLeague
     * @return Game
     */
    public function setIsLeague(bool $isLeague): Game
    {
        $this->isLeague = $isLeague;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNoOfPlayers(): ?int
    {
        return $this->getResults()
            ? $this->getResults()->count()
            : null;
    }
}

