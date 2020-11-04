<?php


namespace AppBundle\PlayerStats;


use Doctrine\Common\Collections\Collection;

class OverallStatsFactory
{
    public function getOverallStats(Collection $games): OverallStats
    {
        $overallStats = new OverallStats();
        $overallStats->setGames($games);

        return $overallStats;
    }
}