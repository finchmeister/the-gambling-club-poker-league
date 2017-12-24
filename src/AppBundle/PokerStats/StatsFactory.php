<?php


namespace AppBundle\PokerStats;

use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

class StatsFactory
{

    private $resultRepository;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        ResultRepository $resultRepository,
        EntityManager $entityManager
    ) {
        $this->resultRepository = $resultRepository;
        $this->entityManager = $entityManager;
    }

    public function initialisePlayerStats(): PlayerStats
    {
        return new PlayerStats(
            $this->resultRepository
        );
    }

    public function initialiseHostStats(): HostStats
    {
        return new HostStats(
            $this->resultRepository
        );
    }

    public function getAllPlayerStats(Player $player): PlayerStatsInterface
    {
        $results = $player->getResults();
        $playerStats = $this->initialisePlayerStats();
        return $playerStats->setResults($results);
    }

    public function getHostStats(Player $host): HostStats
    {
        $results = $this->entityManager->getRepository(Result::class)
            ->getAllResultsForHost($host);

        $hostStats = $this->initialiseHostStats();
        return $hostStats->setResults(new ArrayCollection($results));
    }
}
