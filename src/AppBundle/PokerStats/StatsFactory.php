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

    public function initialisePlayerStats(Player $player): PlayerStats
    {
        return new PlayerStats(
            $this->resultRepository,
            $player
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
        $playerStats = $this->initialisePlayerStats($player);
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

    /**
     * @return PlayerStatsInterface[]
     */
    public function getAllPlayersStats(): array
    {
        $allPlayersStats = [];
        $players = $this->entityManager->getRepository(Player::class)->findAll();
        foreach ($players as $player) {
            $allPlayersStats[] = ($this->getAllPlayerStats($player));
        }
        usort($allPlayersStats, function (PlayerStatsInterface $a, PlayerStatsInterface $b) {
            return $b->getSumGeneralPoints() <=> $a->getSumGeneralPoints();
        });
        return $allPlayersStats;
    }

}
