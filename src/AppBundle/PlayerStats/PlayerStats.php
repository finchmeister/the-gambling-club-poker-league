<?php


namespace AppBundle\PlayerStats;

use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use AppBundle\Helper\ArrayHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Interface ComputePlayerStats
 * @package AppBundle\PlayerStats
 */
class PlayerStats
{


    /**
     * @var Player
     */
    private $player;

    /**
     * @var Result[]|Collection
     */
    private $results;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    /**
     * @return Result[]|Collection
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function setPlayer(Player $player): PlayerStats
    {
        $this->player = $player;
        return $this;
    }

    public function setResults(Collection $results): PlayerStats
    {
        $this->results = $results;
        return $this;
    }

    public function getGamesPlayed(): int
    {
        return $this->getResults()->count();
    }

    public function getGamesWon(): ?int
    {
        return $this->getResults()->filter(
            function (Result $result) {
                return $result->getPosition() === 1;
            }
        )->count();
    }

    public function getGamesNotWon(): ?int
    {
        return $this->getGamesPlayed() - $this->getGamesWon();
    }

    public function getGamesPaid(): ?int
    {
        return $this->getResults()->filter(
            function (Result $result) {
                return $result->getWinnings() > 0;
            }
        )->count();
    }

    public function getGamesNotPaid(): ?int
    {
        return $this->getGamesPlayed() - $this->getGamesPaid();
    }

    public function getWinRatio()
    {
        return $this->getGamesPlayed() > 0
            ? $this->getGamesWon()/$this->getGamesPlayed()
            : null;
    }

    public function getPaidRatio()
    {
        return $this->getGamesPlayed() > 0
            ? $this->getGamesPaid()/$this->getGamesPlayed()
            : null;
    }

    public function getLeaguePosition()
    {
        // todo
    }

    public function getForm()
    {
        // TODO, sort is probably wrong
        return $this->getResults()->map(
            function (Result $result) {
                return $result->getPosition();
            }
        );
    }

    public function getCashWon(): float
    {
        return array_sum($this->getResults()->map(
            function (Result $result) {
                return $result->getWinnings();
            }
        )->toArray());
    }

    public function getBoughtIn(): float
    {
        return array_sum($this->getResults()->map(
            function (Result $result) {
                return $result->getBoughtIn();
            }
        )->toArray());
    }

    public function getNet(): float
    {
        return $this->getCashWon() - $this->getBoughtIn();
    }

    public function getNoOfRebuys(): int
    {
        return array_sum($this->getResults()->map(
            function (Result $result) {
                return $result->getNoOfRebuys();
            }
        )->toArray());
    }

    public function getAverageWin(): ?float
    {
        return $this->getGamesPlayed() > 0
            ? $this->getCashWon()/$this->getGamesPlayed()
            : null;
    }

    public function getAverageProfit(): ?float
    {
        return $this->getGamesPlayed() > 0
            ? $this->getNet()/$this->getGamesPlayed()
            : null;
    }

    public function getAverageLoss(): ?float
    {
        return $this->getGamesPlayed() > 0
            ? $this->getBoughtIn()/$this->getGamesPlayed()
            : null;
    }

    public function getSnacksProvided(): ?int
    {
        return $this->getResults()->filter(
            function (Result $result) {
                $game = $result->getGame();
                return $game->isLeague()
                    && $game->getSnacksProvider() === $this->player;
            }
        )->count();
    }

    public function getHighestPosition(): ?int
    {
        return max($this->getForm()->toArray());
    }

    public function getBiggestWin(): float
    {
        return max($this->getResults()->map(
            function (Result $result) {
                return $result->getWinnings();
            }
        )->toArray());
    }

    public function getMaxProfit(): float
    {
        return max($this->getResults()->map(
            function (Result $result) {
                return $result->getNet();
            }
        )->toArray());
    }

    public function getBiggestLoss(): float
    {
        return max($this->getResults()->map(
            function (Result $result) {
                return $result->getBoughtIn();
            }
        )->toArray());
    }

    public function getAveragePosition(): ?float
    {
        return $this->getGamesPlayed() > 0
            ? array_sum($this->getForm()->toArray())/$this->getGamesPlayed()
            : null;
    }

    public function getMostCommonPosition(): ?int
    {
        return ArrayHelper::getArrayMode($this->getForm()->toArray());
    }

    public function getMiddlePosition(): ?float
    {
        return ArrayHelper::getArrayMedian($this->getForm()->toArray());
    }
}