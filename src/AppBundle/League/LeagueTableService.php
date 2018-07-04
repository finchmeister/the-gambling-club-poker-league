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

        return $leagueTableResults;
    }

    public function getLastUpdated(): ?\DateTimeInterface
    {
        $result = $this->em->getRepository(Result::class)
            ->getLastUpdated();
        return $result['updatedAt'] ?? null;
    }

}