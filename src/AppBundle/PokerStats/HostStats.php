<?php


namespace AppBundle\PokerStats;

use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class HostStats
{
    /**
     * @var Result[]|Collection
     */
    private $results;

    /**
     * @var Game[]|Collection
     */
    private $games;
    /**
     * @var Player
     */
    private $host;

    private $resultRepository;

    public function __construct(
        ResultRepository $resultRepository
    ) {
        $this->resultRepository = $resultRepository;
        $this->results = new ArrayCollection();
    }

    /**
     * @param Game[]|Collection $games
     * @return HostStats
     */
    public function setGames(Collection $games): HostStats
    {
        $this->games = $games;
        foreach ($this->games as $game) {
            foreach ($game->getResults() as $result) {
                $this->results->add($result);
            }
        }
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
     * @return HostStats
     */
    public function setHost(Player $host): HostStats
    {
        $this->host = $host;
        return $this;
    }

    public function getCountGamesPlayed()
    {
        return $this->games->count();
    }

    public function getSumCashWon()
    {
        return $this->resultRepository->getSumCashWon($this->results);
    }

    public function getSumRebuys()
    {
        return $this->resultRepository->getSumRebuys($this->results);
    }

    public function getMaxCountWinsPlayer(): ?Player
    {
        return $this->resultRepository->getMaxCountWinsPlayer($this->results);
    }

    public function getMaxCountWins(): ?int
    {
        return $this->resultRepository->getMaxCountWins($this->results);
    }

    public function getCountHostWins(): ?int
    {
        return $this->resultRepository->getCountPlayerWins($this->host, $this->results);
    }

    public function getFortressRatio(): ?float
    {
        return $this->getCountGamesPlayed() > 0
            ? $this->getCountHostWins()/$this->getCountGamesPlayed()
            : null;
    }


}