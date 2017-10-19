<?php

namespace AppBundle\Entity;

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
}

