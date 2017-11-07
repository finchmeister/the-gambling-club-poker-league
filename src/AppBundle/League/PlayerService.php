<?php


namespace AppBundle\League;

use AppBundle\Entity\Player;
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
        return $this->getPlayersWinLoseStats();
    }

    public function getPlayerWinLoseStats(Player $player)
    {
        return $this->getPlayersWinLoseStats($player)[0];
    }

    public function getPlayersWinLoseStats(Player $player = null)
    {
        $playerStats = $this->em->getRepository(Result::class)
            ->getPlayersWinLoseStats($player);

        foreach ($playerStats as &$playerStat) {
            $playerStat['ratio'] = $playerStat['gamesWon']/$playerStat['gamesPlayed'];
        }

        return $playerStats;
    }


}