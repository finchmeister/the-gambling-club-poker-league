<?php

namespace AppBundle\Entity;

use AppBundle\PokerStats\PlayerStatsInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Player
 *
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlayerRepository")
 */
class Player
{
    public const POKERSTARS_ID = 18;
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
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $profilePicturePublicUrl = null;

    /**
     * @var File|null
     * @Assert\Image(
     *     maxSize = "1M",
     *     mimeTypes = {"image/jpeg", "image/png"},
     * )
     */
    private $profilePicture;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var ArrayCollection|League[]
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\League", mappedBy="players")
     */
    private $leagues;

    /**
     * @var PlayerStatsInterface
     */
    private $playerStats;

    /**
     * @var bool
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $hidePlayer = false;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->results = new ArrayCollection();
        $this->leagues = new ArrayCollection();
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
     * @param int $id
     * @return Player
     */
    public function setId(int $id): Player
    {
        $this->id = $id;
        return $this;
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
     * @return string
     */
    public function getProfilePicturePublicUrl(): ?string
    {
        return $this->profilePicturePublicUrl;
    }

    /**
     * @param UploadedFile|string $profilePicturePublicUrl
     * @return Player
     */
    public function setProfilePicturePublicUrl($profilePicturePublicUrl): Player
    {
        $this->profilePicturePublicUrl = $profilePicturePublicUrl;
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
     * @return PlayerStatsInterface|null
     */
    public function getPlayerStats(): ?PlayerStatsInterface
    {
        return $this->playerStats;
    }

    /**
     * @param PlayerStatsInterface $playerStats
     * @return Player
     */
    public function setPlayerStats(PlayerStatsInterface $playerStats): Player
    {
        $this->playerStats = $playerStats;
        return $this;
    }

    /**
     * @return null|File
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @return string
     */
    public function getProfilePicturePath(): string
    {
        return sprintf('images/profile/%s.jpg', md5(uniqid()));
    }

    /**
     * @param null|File|string $profilePicture
     * @return Player
     */
    public function setProfilePicture($profilePicture): Player
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }

    /**
     * @return League[]|ArrayCollection
     */
    public function getLeagues()
    {
        return $this->leagues;
    }

    public function addLeague(League $league): void
    {
        $this->leagues[] = $league;
    }

    public function removeLeague(League $league): void
    {
        $this->leagues->removeElement($league);
    }

    /**
     * @return bool
     */
    public function isHidePlayer(): bool
    {
        return $this->hidePlayer;
    }

    /**
     * @param bool $hidePlayer
     * @return Player
     */
    public function setHidePlayer(bool $hidePlayer): Player
    {
        $this->hidePlayer = $hidePlayer;
        return $this;
    }
}

