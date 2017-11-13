<?php


namespace AppBundle\PlayerStats\Model;

use AppBundle\Entity\Player;

class PlayerStats
{
    /**
     * @var Player
     */
    private $player;

    /**
     * @var integer
     */
    private $gamesPlayed;

    /**
     * @var integer
     */
    private $gamesWon;

    /**
     * @var float
     */
    private $winRatio; // $gamesWon/$gamesPlayed

    /**
     * @var int
     */
    private $leaguePosition;

    /**
     * @var array of positions
     */
    private $form;

    /**
     * @var float
     */
    private $cashWon;

    /**
     * @var float
     */
    private $boughtIn;

    /**
     * @var float
     */
    private $net;

    /**
     * @var int
     */
    private $noOfRebuys;


    /**
     * @var float
     */
    private $averageWin;

    /**
     * @var float
     */
    private $averageLoss;

    /**
     * @var float
     */
    private $averageProfit;

    /**
     * @var int
     */
    private $snacksProvided;

    /**
     * @var int
     */
    private $highestPosition;

    /**
     * @var float
     */
    private $biggestWin;

    /**
     * @var float
     */
    private $maxProfit;

    /**
     * @var float
     */
    private $biggestLoss;

    /**
     * @var float
     */
    private $averagePosition; // Mean

    /**
     * @var int
     */
    private $mostCommonPosition; // Mode

    /**
     * @var int
     */
    private $middlePosition;

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     * @return PlayerStats
     */
    public function setPlayer(Player $player): PlayerStats
    {
        $this->player = $player;
        return $this;
    }

    /**
     * @return int
     */
    public function getGamesPlayed(): int
    {
        return $this->gamesPlayed;
    }

    /**
     * @param int $gamesPlayed
     * @return PlayerStats
     */
    public function setGamesPlayed(int $gamesPlayed): PlayerStats
    {
        $this->gamesPlayed = $gamesPlayed;
        return $this;
    }

    /**
     * @return int
     */
    public function getGamesWon(): int
    {
        return $this->gamesWon;
    }

    /**
     * @param int $gamesWon
     * @return PlayerStats
     */
    public function setGamesWon(int $gamesWon): PlayerStats
    {
        $this->gamesWon = $gamesWon;
        return $this;
    }

    /**
     * @return float
     */
    public function getWinRatio(): float
    {
        return $this->winRatio;
    }

    /**
     * @param float $winRatio
     * @return PlayerStats
     */
    public function setWinRatio(float $winRatio): PlayerStats
    {
        $this->winRatio = $winRatio;
        return $this;
    }

    /**
     * @return int
     */
    public function getLeaguePosition(): int
    {
        return $this->leaguePosition;
    }

    /**
     * @param int $leaguePosition
     * @return PlayerStats
     */
    public function setLeaguePosition(int $leaguePosition): PlayerStats
    {
        $this->leaguePosition = $leaguePosition;
        return $this;
    }

    /**
     * @return array
     */
    public function getForm(): array
    {
        return $this->form;
    }

    /**
     * @param array $form
     * @return PlayerStats
     */
    public function setForm(array $form): PlayerStats
    {
        $this->form = $form;
        return $this;
    }

    /**
     * @return float
     */
    public function getCashWon(): float
    {
        return $this->cashWon;
    }

    /**
     * @param float $cashWon
     * @return PlayerStats
     */
    public function setCashWon(float $cashWon): PlayerStats
    {
        $this->cashWon = $cashWon;
        return $this;
    }

    /**
     * @return float
     */
    public function getBoughtIn(): float
    {
        return $this->boughtIn;
    }

    /**
     * @param float $boughtIn
     * @return PlayerStats
     */
    public function setBoughtIn(float $boughtIn): PlayerStats
    {
        $this->boughtIn = $boughtIn;
        return $this;
    }

    /**
     * @return float
     */
    public function getNet(): float
    {
        return $this->net;
    }

    /**
     * @param float $net
     * @return PlayerStats
     */
    public function setNet(float $net): PlayerStats
    {
        $this->net = $net;
        return $this;
    }

    /**
     * @return int
     */
    public function getNoOfRebuys(): int
    {
        return $this->noOfRebuys;
    }

    /**
     * @param int $noOfRebuys
     * @return PlayerStats
     */
    public function setNoOfRebuys(int $noOfRebuys): PlayerStats
    {
        $this->noOfRebuys = $noOfRebuys;
        return $this;
    }

    /**
     * @return float
     */
    public function getAverageWin(): float
    {
        return $this->averageWin;
    }

    /**
     * @param float $averageWin
     * @return PlayerStats
     */
    public function setAverageWin(float $averageWin): PlayerStats
    {
        $this->averageWin = $averageWin;
        return $this;
    }

    /**
     * @return float
     */
    public function getAverageLoss(): float
    {
        return $this->averageLoss;
    }

    /**
     * @param float $averageLoss
     * @return PlayerStats
     */
    public function setAverageLoss(float $averageLoss): PlayerStats
    {
        $this->averageLoss = $averageLoss;
        return $this;
    }

    /**
     * @return float
     */
    public function getAverageProfit(): float
    {
        return $this->averageProfit;
    }

    /**
     * @param float $averageProfit
     * @return PlayerStats
     */
    public function setAverageProfit(float $averageProfit): PlayerStats
    {
        $this->averageProfit = $averageProfit;
        return $this;
    }

    /**
     * @return int
     */
    public function getSnacksProvided(): int
    {
        return $this->snacksProvided;
    }

    /**
     * @param int $snacksProvided
     * @return PlayerStats
     */
    public function setSnacksProvided(int $snacksProvided): PlayerStats
    {
        $this->snacksProvided = $snacksProvided;
        return $this;
    }

    /**
     * @return int
     */
    public function getHighestPosition(): int
    {
        return $this->highestPosition;
    }

    /**
     * @param int $highestPosition
     * @return PlayerStats
     */
    public function setHighestPosition(int $highestPosition): PlayerStats
    {
        $this->highestPosition = $highestPosition;
        return $this;
    }

    /**
     * @return float
     */
    public function getBiggestWin(): float
    {
        return $this->biggestWin;
    }

    /**
     * @param float $biggestWin
     * @return PlayerStats
     */
    public function setBiggestWin(float $biggestWin): PlayerStats
    {
        $this->biggestWin = $biggestWin;
        return $this;
    }

    /**
     * @return float
     */
    public function getMaxProfit(): float
    {
        return $this->maxProfit;
    }

    /**
     * @param float $maxProfit
     * @return PlayerStats
     */
    public function setMaxProfit(float $maxProfit): PlayerStats
    {
        $this->maxProfit = $maxProfit;
        return $this;
    }

    /**
     * @return float
     */
    public function getBiggestLoss(): float
    {
        return $this->biggestLoss;
    }

    /**
     * @param float $biggestLoss
     * @return PlayerStats
     */
    public function setBiggestLoss(float $biggestLoss): PlayerStats
    {
        $this->biggestLoss = $biggestLoss;
        return $this;
    }

    /**
     * @return float
     */
    public function getAveragePosition(): float
    {
        return $this->averagePosition;
    }

    /**
     * @param float $averagePosition
     * @return PlayerStats
     */
    public function setAveragePosition(float $averagePosition): PlayerStats
    {
        $this->averagePosition = $averagePosition;
        return $this;
    }

    /**
     * @return int
     */
    public function getMostCommonPosition(): int
    {
        return $this->mostCommonPosition;
    }

    /**
     * @param int $mostCommonPosition
     * @return PlayerStats
     */
    public function setMostCommonPosition(int $mostCommonPosition): PlayerStats
    {
        $this->mostCommonPosition = $mostCommonPosition;
        return $this;
    }

    /**
     * @return int
     */
    public function getMiddlePosition(): int
    {
        return $this->middlePosition;
    }

    /**
     * @param int $middlePosition
     * @return PlayerStats
     */
    public function setMiddlePosition(int $middlePosition): PlayerStats
    {
        $this->middlePosition = $middlePosition;
        return $this;
    } // Mean


}
