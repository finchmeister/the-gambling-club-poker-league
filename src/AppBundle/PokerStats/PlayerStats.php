<?php


namespace AppBundle\PokerStats;


use AppBundle\Entity\Result;
use Doctrine\Common\Collections\Collection;

class PlayerStats implements PlayerStatsInterface
{
    /**
     * @var ResultRepository
     */
    protected $resultRepository;

    /**
     * @var Result[]|Collection
     */
    protected $results;

    public function __construct(
        ResultRepository $resultRepository
    ) {
        $this->resultRepository = $resultRepository;
    }

    /**
     * @param Result[]|Collection $results
     * @return PlayerStats
     */
    public function setResults(Collection $results): PlayerStats
    {
        $this->results = $results;
        return $this;
    }

    public function getNoOfGamesPlayed(): int
    {
        return $this->results->count();
    }

    public function getCashWon()
    {
        // TODO: Implement getCashWon() method.
    }

    public function getGamesWon()
    {
        // TODO: Implement getGamesWon() method.
    }

    public function getBoughtIn()
    {
        // TODO: Implement getBoughtIn() method.
    }

    public function getNet()
    {
        // TODO: Implement getNet() method.
    }

    public function getNoOfRebuys()
    {
        // TODO: Implement getNoOfRebuys() method.
    }

    public function getGamesPaid()
    {
        // TODO: Implement getGamesPaid() method.
    }


}