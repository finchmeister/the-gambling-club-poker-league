<?php


namespace AppBundle\PlayerStats;


use Doctrine\Common\Collections\Collection;

class ComputeStats
{

    /**
     * @var OverallStats
     */
    private $overallStats;

    // TODO, interact will all stats from here:
    public function __construct(
        OverallStats $overallStats
    ) {
        $this->overallStats = $overallStats;
    }

    public function getOverallStats(Collection $games): OverallStats
    {
        $this->overallStats->setGames($games);
        return $this->overallStats;
    }

}