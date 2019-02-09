<?php


namespace AppBundle\League;

use AppBundle\Entity\Game;

class LeagueGame
{
    /**
     * @var LeaguePointsInterface
     */
    protected $leaguePoints;

    /**
     * @var bool
     */
    protected $updated = false;

    /**
     * @deprecated done via entity
     * @param LeaguePointsInterface $leaguePoints
     */
//    public function __construct(
//        LeaguePointsInterface $leaguePoints
//    ) {
//        $this->leaguePoints = $leaguePoints;
//    }

    /**
     * @deprecated
     * @param Game $game
     * @return Game
     */
    public function getLeagueGame(Game $game): Game
    {
        $this->updated = false;
        foreach ($game->getResults() as $result) {
            $leaguePoints = $this->leaguePoints->getLeaguePoints($result);
            if ($result->getLeaguePoints() !== $leaguePoints) {
                $result->setLeaguePoints($leaguePoints);
                $this->updated = true;
            }
        }
        return $game;
    }

    /**
     * @return bool
     */
    public function isUpdated() : bool
    {
        return $this->updated;
    }

}