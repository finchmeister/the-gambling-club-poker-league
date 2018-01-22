<?php

namespace AppBundle\PokerStats;

interface PlayerStatsInterface
{

    public function getCountGamesPlayed();

    public function getSumCashWon();

    public function getCountGamesWon();

    public function getWinRatio();

    public function getSumBoughtIn();

    public function getSumRebuys();

    public function getNet();

    public function getCountGamesPaid();

    public function getGamesPaidRatio();

    public function getMeanWin();

    public function getMeanNet();

    public function getMeanBoughtIn();

    public function getBestPosition();

    public function getMaxCashWin();

    public function getMaxProfit();

    public function getMinProfit();

    public function getMaxBoughtIn();

    public function getForm();

    public function getMeanPosition();

    public function getSumGeneralPoints();
}
