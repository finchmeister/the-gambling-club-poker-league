<?php


namespace AppBundle\PokerStats;


use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use Doctrine\Common\Collections\Collection;

class HostStats implements HostStatsInterface
{
    /**
     * @var Result[]|Collection
     */
    private $results;

    private $resultRepository;

    public function __construct(
        ResultRepository $resultRepository
    ) {
        $this->resultRepository = $resultRepository;
    }

    /**
     * @param Result[]|Collection $results
     * @return HostStats
     */
    public function setResults(Collection $results): HostStats
    {
        $this->results = $results;
        return $this;
    }

    public function getCountGamesPlayed()
    {
        // TODO: Implement getCountGamesPlayed() method.
    }

    public function getSumCashWon()
    {
        return $this->resultRepository->getSumCashWon($this->results);
    }

    public function getSumRebuys()
    {
        return $this->resultRepository->getSumRebuys($this->results);
    }

    public function getMaxCountWins(): Player
    {
        // TODO: Implement getMaxCountWins() method.
    }

    public function getFortress()
    {
        // TODO: Implement getFortress() method.
    }


}