<?php


namespace AppBundle\PlayerStats;


use AppBundle\Entity\Player;
use AppBundle\Entity\Result;

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

    public function getAllPlayerStats(Player $player): PlayerStats
    {
        return $this->playerStats->setResults($player->getResults());
    }

    public function getLeaguePlayerStats(Player $player): PlayerStats
    {
        $results = $player->getResults()->filter(
            function (Result $result) {
                return $result->getGame()->isLeague();
            }
        );
        return $this->playerStats->setResults($results);
    }

    public function getNonLeaguePlayerStats(Player $player): PlayerStats
    {
        $results = $player->getResults()->filter(
            function (Result $result) {
                return !$result->getGame()->isLeague();
            }
        );
        return $this->playerStats->setResults($results);
    }
}