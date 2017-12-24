<?php

namespace AppBundle\PokerStats;

use AppBundle\Entity\Player;

interface OverallStatsInterface
{
    public function getCountGamesPlayed();

    public function getSumCashWon();

    public function getSumRebuys();

    public function getAveragePot();

    public function getMaxPot();

    public function getMaxCountWins(): Player;
}