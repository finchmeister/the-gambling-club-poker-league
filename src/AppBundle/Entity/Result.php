<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Game")
     */
    private $game;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     */
    private $player;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var int
     *
     * @ORM\Column(name="winnings", type="float")
     */
    private $winnings;

    /**
     * @var int
     *
     * @ORM\Column(name="no_of_rebuys", type="integer")
     */
    private $noOfRebuys;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Result
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
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
    public function setGame(Game $game): Result
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


}

