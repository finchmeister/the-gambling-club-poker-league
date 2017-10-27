<?php


namespace AppBundle\League;

use AppBundle\Entity\Result;

/**
 * Class SimpleOnePointPerPosition
 * @package AppBundle\LeaguePoints
 */
class SimpleOnePointPerPosition implements LeaguePointsInterface
{
    /**
     * @param Result $result
     * @return float|null
     */
    public function getLeaguePoints(Result $result): ?float
    {
        if ($result->getPlayer()->isLeaguePlayer()) {
            return (float) $result->getGame()->getNoOfPlayers() + 1 - $result->getPosition();
        }
        return null;
    }
}