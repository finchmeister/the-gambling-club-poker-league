<?php


namespace AppBundle\League;

use AppBundle\Entity\Result;
use Doctrine\ORM\EntityManagerInterface;

class PlayerService
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function getAllPlayersWinLoseStats()
    {
        $playerStats = $this->em->getRepository(Result::class)
            ->getPlayersWinLoseStats();

        foreach ($playerStats as &$playerStat) {
            $playerStat['ration'] = $playerStat['gamesWon']/$playerStat['gamesPlayed'];
        }

        return $playerStats;
    }


}