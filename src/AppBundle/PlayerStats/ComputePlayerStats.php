<?php


namespace AppBundle\PlayerStats;


use AppBundle\Entity\Player;

class ComputePlayerStats
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

    public function getPlayerStats(Player $player): PlayerStats
    {
        return $this->playerStats->setPlayer($player);
    }
}