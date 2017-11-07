<?php


namespace AppBundle\PlayerStats;

use AppBundle\Entity\Player;

/**
 * Interface PlayerStatsInterface
 * @package AppBundle\PlayerStats
 */
interface PlayerStatsInterface
{
    public function getStats(Player $player);
}