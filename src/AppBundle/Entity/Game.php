<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
    const DEFAULT_NO_OF_PLAYERS = 6;

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
     * @var int
     *
     * @ORM\Column(name="no_of_players", type="integer")
     * @Assert\GreaterThan(0)
     */
    private $noOfPlayers = self::DEFAULT_NO_OF_PLAYERS;

    /**
     * @var Result[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Result", mappedBy="game")
     */
    private $results;

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
     * @return int
     */
    public function getNoOfPlayers(): ?int
    {
        return $this->noOfPlayers;
    }

    /**
     * @param int $noOfPlayers
     * @return Game
     */
    public function setNoOfPlayers(int $noOfPlayers): Game
    {
        $this->noOfPlayers = $noOfPlayers;
        return $this;
    }

}

