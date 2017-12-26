<?php


namespace AppBundle\PokerStats;

use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
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
        $games = $this->entityManager->getRepository(Game::class)
            ->getAllHostGames($host);

        $hostStats = $this->initialiseHostStats();
        $hostStats
            ->setGames(new ArrayCollection($games))
            ->setHost($host);
        return $hostStats;
    }

}
