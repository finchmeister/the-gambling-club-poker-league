<?php

namespace AppBundle\PokerStats;

interface PlayerStatsInterface
{

    public function getNoOfGamesPlayed();

    public function getCashWon();

    public function getGamesWon();

    public function getBoughtIn();

    public function getNet();

    public function getNoOfRebuys();

    public function getGamesPaid();

}
