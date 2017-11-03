<?php


namespace AppBundle\League;


use AppBundle\Entity\Game;
use AppBundle\Entity\Result;
use Doctrine\ORM\EntityManagerInterface;

class LeagueTableService
{
    protected $em;

    public function __construct(
        EntityManagerInterface $em
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

    public function getLastUpdated()
    {
        $result = $this->em->getRepository(Result::class)
            ->getLastUpdated();
        return $result['updatedAt'];
    }

}