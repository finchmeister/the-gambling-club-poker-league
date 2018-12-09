<?php

namespace AppBundle\Repository;

use AppBundle\Entity\League;
use AppBundle\Entity\Player;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * ResultRepository
 *
 */
class ResultRepository extends EntityRepository
{
    public function getPlayersLeagueResults(Player $player, League $league): array
    {
        $qb =  $this->createQueryBuilder('r')
            ->leftJoin('r.game', 'g')
            ->innerJoin('r.player', 'p', Expr\Join::WITH, 'p = :player')
            ->setParameter('player', $player)
            ->andWhere('g.date >= :startDate')
            ->setParameter('startDate', $league->getStartDate());
        if ($league->getEndDate() !== null) {
            $qb->andWhere('g.date <= :endDate')
                ->setParameter('endDate', $league->getEndDate());
        }
        return $qb->getQuery()->getResult();
    }

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
