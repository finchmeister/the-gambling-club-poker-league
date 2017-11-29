<?php


namespace AppBundle\PlayerStats;


use AppBundle\Entity\Game;
use AppBundle\Entity\Result;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use function PHPSTORM_META\elementType;

class OverallStats
{
    /**
     * @var Game[]|Collection
     */
    private $games = null;
    /**
     * @var int
     */
    private $noOfGamesPlayed = null;

    /**
     * @var float
     */
    private $cashWon = null;

    /**
     * @var int
     */
    private $noOfRebuys = null;

    /**
     * @var float
     */
    private $averagePot = null;

    /**
     * @var float
     */
    private $biggestPot = null;

    /**
     * @var float
     */
    private $biggestWin = null;

    /**
     * @var float
     */
    private $biggestLoss = null;

    /**
     * @var float
     */
    private $biggestProfit = null;

    /**
     * @var int
     */
    private $mostWins = null;

    /**
     * @var float
     */
    private $highestAverage;

    // histogram for host and wins

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    /**
     * @return Game[]|Collection
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    /**
     * @param Game[]|Collection $games
     */
    public function setGames(Collection $games)
    {
        $this->games = $games;
    }

    /**
     * @return int
     */
    public function getNoOfGamesPlayed(): int
    {
        if ($this->noOfGamesPlayed === null) {
            $this->noOfGamesPlayed = $this->games->count();
        }
        return $this->noOfGamesPlayed;
    }

    public function sumPropertyOfResults(\Closure $closure)
    {
        return array_sum($this->getGames()->map($closure)->toArray());
    }

    /**
     * @return float
     */
    public function getCashWon(): float
    {
        if ($this->cashWon === null) {
            $cashWonFromGames = function (Game $game) {
                return array_sum($game->getResults()->map(
                    function (Result $result) {
                        return $result->getWinnings();
                    }
                )->toArray());
            };
            $this->cashWon = $this->sumPropertyOfResults($cashWonFromGames);
        }
        return $this->cashWon;
    }

    /**
     * @return int
     */
    public function getNoOfRebuys(): int
    {
        if ($this->noOfRebuys === null) {
            $noOfRebuys = function (Game $game) {
                return array_sum($game->getResults()->map(
                    function (Result $result) {
                        return $result->getNoOfRebuys();
                    }
                )->toArray());
            };
            $this->noOfRebuys = $this->sumPropertyOfResults($noOfRebuys);
        }
        return $this->noOfRebuys;
    }

    /**
     * @return float
     */
    public function getAveragePot(): float
    {
        return $this->getCashWon()/$this->getNoOfGamesPlayed();
    }

    /**
     * @return float
     */
    public function getBiggestPot(): float
    {
        return $this->biggestPot;
    }

    /**
     * @return float
     */
    public function getBiggestWin(): float
    {
        return $this->biggestWin;
    }

    /**
     * @return float
     */
    public function getBiggestLoss(): float
    {
        return $this->biggestLoss;
    }

    /**
     * @return float
     */
    public function getBiggestProfit(): float
    {
        return $this->biggestProfit;
    }

    /**
     * @return int
     */
    public function getMostWins(): int
    {
        return $this->mostWins;
    }

    /**
     * @return float
     */
    public function getHighestAverage(): float
    {
        return $this->highestAverage;
    }

    // TODO: Look at base class for both stats
}