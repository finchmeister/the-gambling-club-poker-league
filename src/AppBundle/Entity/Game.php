<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 */
class Game
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     */
    private $host;

    /**
     * @var float
     *
     * @ORM\Column(name="buy_in", type="float")
     */
    private $buyIn = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="no_of_players", type="integer")
     */
    private $noOfPlayers;

    /**
     * @var Result[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Result", mappedBy="game")
     */
    private $results;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
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
    public function getHost(): Player
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
    public function getNoOfPlayers(): int
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

