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

    public function getCountGamesPlayed(): int
    {
        return $this->results->count();
    }

    public function getSumCashWon(): int
    {
        return $this->resultRepository->getSumCashWon($this->results);
    }

    public function getCountGamesWon(): int
    {
        return $this->resultRepository->getCountGamesWon($this->results);
    }

    public function getWinRatio(): ?float
    {
        return $this->getCountGamesPlayed() > 0
            ? $this->getCountGamesWon() / $this->getCountGamesPlayed()
            : 0;
    }

    public function getSumBoughtIn(): int
    {
        return $this->resultRepository->getSumBoughtIn($this->results);
    }

    public function getSumRebuys(): int
    {
        return $this->resultRepository->getSumRebuys($this->results);
    }

    public function getNet(): int
    {
        return $this->getSumCashWon() - $this->getSumBoughtIn();
    }

    public function getCountGamesPaid(): int
    {
        return $this->resultRepository->getCountGamesPaid($this->results);
    }

    public function getGamesPaidRatio()
    {
        return $this->getCountGamesPlayed() > 0
            ? $this->getCountGamesPaid() / $this->getCountGamesPlayed()
            : 0;
    }

    public function getMeanWin(): ?float
    {
        return $this->getCountGamesPlayed() > 0
            ? $this->getSumCashWon()/$this->getCountGamesPlayed()
            : null;
    }

    public function getMeanNet(): ?float
    {
        return $this->getCountGamesPlayed() > 0
            ? $this->getNet()/$this->getCountGamesPlayed()
            : null;
    }

    public function getMeanBoughtIn(): ?float
    {
        return $this->getCountGamesPlayed() > 0
            ? $this->getSumBoughtIn()/$this->getCountGamesPlayed()
            : null;
    }

    public function getBestPosition(): ?int
    {
        return $this->resultRepository->getMinPosition($this->results);
    }

    public function getMaxCashWin(): ?int
    {
        return $this->resultRepository->getMaxCashWon($this->results);
    }

    public function getMaxProfit(): ?int
    {
        return $this->resultRepository->getMaxNet($this->results);
    }

    public function getMinProfit(): ?int
    {
        return $this->resultRepository->getMinNet($this->results);
    }

    public function getMaxBoughtIn(): ?int
    {
        return $this->resultRepository->getMaxBoughtIn($this->results);
    }

    public function getForm()
    {
        return $this->resultRepository->getPositions($this->results);
    }

    public function getMeanPosition(): ?float
    {
        return $this->getCountGamesPlayed() > 0
            ? array_sum($this->resultRepository->getPositions($this->results)->toArray())
            / $this->getCountGamesPlayed()
            : null;
    }

    public function getSumGeneralPoints()
    {
        return $this->resultRepository->getSumGeneralPoints($this->results);
    }

}