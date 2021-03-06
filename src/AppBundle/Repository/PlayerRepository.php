<?php

namespace AppBundle\Repository;

use AppBundle\Entity\League;
use AppBundle\Entity\Player;
use Doctrine\ORM\EntityRepository;

class PlayerRepository extends EntityRepository
{
    /**
     * @return Player[]
     */
    public function getDisplayedPlayers()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->andWhere($qb->expr()->eq('p.hidePlayer', 0));

        return $qb->getQuery()->getResult();
    }

    public function getGamesPlayed(Player $player)
    {
        return $this->createQueryBuilder('player')
            ->leftJoin('player', 'result');
    }

    public function getAllOnlinePlayers()
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->leftJoin('p.results', 'r')
            ->leftJoin('r.game', 'g')
            ->where($qb->expr()->eq('g.isOnline', true))
            ->andWhere($qb->expr()->eq('p.hidePlayer', 0))
        ;

        return $qb->getQuery()->getResult();
    }

    public function getAllWhoHavePlayed()
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->andWhere($qb->expr()->eq('p.hidePlayer', 0))
            ->innerJoin('p.results', 'r');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param League $league
     * @return int
     */
    public function getNoOfGamesAllPlayed(League $league): int
    {
        $qb = $this->createQueryBuilder('player');
        $expr = $qb->expr();
        $qb
            ->select('COUNT(r.id) as games_played')
            ->innerJoin('player.results', 'r')
            ->innerJoin('r.game', 'g')
            ->innerJoin('player.leagues', 'l', 'WITH', $expr->eq('l.id', $league->getId()))
            ->andWhere($expr->eq('g.isLeague', true))
            ->andWhere('g.date > :startDate')
            ->setParameter('startDate', $league->getStartDate()->sub(new \DateInterval('P1D')));
        if ($league->getEndDate() !== null) {
            $qb->andWhere('g.date <= :endDate')
                ->setParameter('endDate', $league->getEndDate());
        }

        $qb
            ->groupBy('player.id')
            ->orderBy('games_played', 'ASC')
            ->setMaxResults(1);
        $result = $qb->getQuery()->getResult();

        return $result[0]['games_played'] ?? 0;
    }
}
