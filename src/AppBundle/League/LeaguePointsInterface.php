<?php


namespace AppBundle\League;

use AppBundle\Entity\Result;

interface LeaguePointsInterface
{
    public function getLeaguePoints(Result $result): ?float;
}