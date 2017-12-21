<?php


namespace AppBundle\PokerStats;


use AppBundle\Entity\Player;

class PlayerStatsFactory
{

    /**
     * @var PlayerStats
     */
    private $playerStats;

    public function __construct(
        PlayerStats $playerStats
    ) {
        $this->playerStats = $playerStats;
    }

    public function getAllPlayerStats(Player $player): PlayerStats
    {
        $results = $player->getResults();
        return $this->playerStats->setResults($results);
    }

    public function getHostStats(Player $host): PlayerStats
    {
    }
}