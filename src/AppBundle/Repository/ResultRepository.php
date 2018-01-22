<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Player;
use Doctrine\ORM\EntityRepository;

/**
 * ResultRepository
 *
 */
class ResultRepository extends EntityRepository
{

    public function getLastUpdated()
    {
        return $this->createQueryBuilder('r')
            ->select('r.updatedAt')
            ->orderBy('r.updatedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    public function getPlayersWinLoseStats(Player $player = null)
    {
        $qb = $this->createQueryBuilder('result')
            ->select('player.name, player.id AS playerId')
            ->join('result.player', 'player')
            ->addSelect('COUNT(result.id) as gamesPlayed')
            ->addSelect('SUM(CASE WHEN result.position = 1 THEN 1 ELSE 0 END) as gamesWon')
            ->groupBy('player.id');

        if ($player) {
            $qb
                ->andWhere('player = :player')
                ->setParameter('player', $player);
        }

        return $qb->getQuery()
            ->getResult();
    }

    public function getAllResultsForHost(Player $host)
    {
        return $this->createQueryBuilder('result')
            ->innerJoin('result.game', 'game')
            ->andWhere('game.host = :host')
            ->setParameter('host', $host)
            ->getQuery()
            ->getResult();
    }
}
