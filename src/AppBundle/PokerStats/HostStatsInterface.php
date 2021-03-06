<?php

namespace AppBundle\PokerStats;

use AppBundle\Entity\Player;

interface HostStatsInterface
{
    public function getCountGamesPlayed();

    public function getSumCashWon();

    public function getSumRebuys();

    public function getMaxCountWinsPlayer(): ?Player;

    public function getFortress();
}