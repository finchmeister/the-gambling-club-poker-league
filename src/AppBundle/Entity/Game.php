<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as TGCPLAssert;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 * @TGCPLAssert\WinningsMatchPot()
 * @ORM\HasLifecycleCallbacks()
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
     * @TGCPLAssert\UniquePlayer()
     * @TGCPLAssert\UniquePosition()
     */
    private $results;

    /**
     * @var bool
     * @ORM\Column(name="is_league", type="boolean")
     */
    private $isLeague = true;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern="/spotify:user:\w+:playlist:\w{22}/",
     *     message="Must be spotify uri"
     * )
     */
    private $spotifyPlaylistUri;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $snacks;

    /**
     * @var Player
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     */
    private $snacksProvider;

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
        $this->results = new ArrayCollection();
        $this->date = new \DateTime();
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
     * @return null|string
     */
    public function getSpotifyPlaylistUri(): ?string
    {
        return $this->spotifyPlaylistUri;
    }

    /**
     * @param null|string $spotifyPlaylistUri
     * @return Game
     */
    public function setSpotifyPlaylistUri($spotifyPlaylistUri)
    {
        $this->spotifyPlaylistUri = $spotifyPlaylistUri;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSnacks(): ?string
    {
        return $this->snacks;
    }

    /**
     * @param null|string $snacks
     * @return Game
     */
    public function setSnacks(string $snacks = null)
    {
        $this->snacks = $snacks;
        return $this;
    }

    /**
     * @return Player
     */
    public function getSnacksProvider(): ?Player
    {
        return $this->snacksProvider;
    }

    /**
     * @param Player $snacksProvider
     * @return Game
     */
    public function setSnacksProvider(Player $snacksProvider = null): Game
    {
        $this->snacksProvider = $snacksProvider;
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

    /**
     * @return int|null
     */
    public function getPot(): ?int
    {
        if ($results = $this->getResults()) {
            $pot = $results->count() * $this->getBuyIn();
            foreach ($results as $result) {
                $pot += $result->getNoOfRebuys() * $this->getBuyIn() + $result->getAddOn();
            }
            return $pot;
        } else {
            return null;
        }
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
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime('now');
    }

    public function hasAddOn(): bool
    {
        return $this->results->filter(function (Result $result) {
            return $result->getAddOn() > 0;
        })->count() > 0;
    }

}

