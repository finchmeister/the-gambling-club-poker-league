<?php


namespace AppBundle\League;


use AppBundle\Entity\Game;
use Doctrine\ORM\EntityManager;

class LeagueTableService
{
    protected $em;

    public function __construct(
        EntityManager $em
    ) {
        $this->em = $em;
    }

    // Given an array of league games

    public function getLeagueTable()
    {
        $leagueTableResults = $this->em->getRepository(Game::class)
            ->getLeagueTable();

        foreach ($leagueTableResults as &$leagueTableResult) {
            $leagueTableResult['net'] = $leagueTableResult['winnings']
                -  $leagueTableResult['boughtIn'];
        }


        return $leagueTableResults;
    }

}