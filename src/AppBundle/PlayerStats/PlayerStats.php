<?php


namespace AppBundle\PlayerStats;


class PlayerStats
{

    private $gamesPlayed;
    private $gamesWon;
    private $winRatio; // $gamesWon/$gamesPlayed

    /**
     * @var int
     */
    private $leaguePosition;

    /**
     * @var array of positions
     */
    private $form;

    private $cashWon;

    private $boughtIn;

    private $net;

    private $noOfRebuys;

    private $averageWin;

    private $averageLoss;

    private $averageProfit;

    private $snacksProvided;

    private $highestPosition;

    private $biggestWin;

    private $maxProfit;

    private $biggestLoss;

    private $averagePosition; // Mean
    private $mostCommonPosition; // Mode
    private $middlePosition; // Mean
}