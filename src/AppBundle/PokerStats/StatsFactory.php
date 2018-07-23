<?php


namespace AppBundle\PokerStats;

use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;

class StatsFactory
{

    private $resultRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /** @var PlayerRepository  */
    private $playerRepository;

    public function __construct(
        ResultRepository $resultRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->resultRepository = $resultRepository;
        $this->entityManager = $entityManager;
        $this->playerRepository = $this->entityManager
            ->getRepository(Player::class);
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

    public function getLeaguePlayerStats(Player $player): PlayerStatsInterface
    {
        $results = $player->getResults()->filter(function (Result $result) {
            return $result->getGame()->isLeague();
        });


        $playerStats = $this->initialisePlayerStats($player);
        return $playerStats->setResults($results);
    }


    public function getLeaguePlayerTopStats(Player $player, int $noOfResults): PlayerStatsInterface
    {
        $results = $player->getResults()->filter(function (Result $result) {
            return $result->getGame()->isLeague();
        })->toArray();
        self::sortResultsByLeaguePoints($results);
        $reducedResults = new ArrayCollection();
        foreach (range(0, $noOfResults-1) as $i) {
            $reducedResults->add($results[$i]);
        }
        $playerStats = $this->initialisePlayerStats($player);
        return $playerStats->setResults($reducedResults);
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
        $players = $this->playerRepository->findAll();
        foreach ($players as $player) {
            $allPlayersStats[] = $this->getAllPlayerStats($player);
        }
        self::sortPlayerStatsByGeneralPoints($allPlayersStats);
        return $allPlayersStats;
    }

    /**
     * @return PlayerStatsInterface[]
     */
    public function getLeaguePlayersStats(): array
    {
        $leaguePlayersStats = [];
        $players = $this->playerRepository->findAllLeaguePlayers();
        foreach ($players as $player) {
            $leaguePlayersStats[] = $this->getLeaguePlayerStats($player);
        }
        self::sortPlayerStatsByLeaguePoints($leaguePlayersStats);
        return $leaguePlayersStats;
    }

    /**
     * @return PlayerStatsInterface[]
     */
    public function getLeaguePlayersTopStats(): array
    {
        $leaguePlayersTopStats = [];
        $players = $this->playerRepository->findAllLeaguePlayers();
        $noOfGamesAllPlayed = $this->getNoOfGamesAllPlayed();
        foreach ($players as $player) {
            $leaguePlayersTopStats[] = $this->getLeaguePlayerTopStats(
                $player,
                $noOfGamesAllPlayed
            );
        }
        self::sortPlayerStatsByLeaguePoints($leaguePlayersTopStats);
        return $leaguePlayersTopStats;
    }

    /**
     * @return int
     */
    public function getNoOfGamesAllPlayed(): int
    {
        return $this->playerRepository->getNoOfGamesAllPlayed();
    }

    /**
     * @param PlayerStatsInterface[] $playerStats
     */
    protected static function sortPlayerStatsByGeneralPoints(array &$playerStats): void
    {
        usort($playerStats, function (PlayerStatsInterface $a, PlayerStatsInterface $b) {
            return $b->getSumGeneralPoints() <=> $a->getSumGeneralPoints();
        });
    }

    /**
     * @param PlayerStatsInterface[] $playerStats
     */
    protected static function sortPlayerStatsByLeaguePoints(array &$playerStats): void
    {
        usort($playerStats, function (PlayerStatsInterface $a, PlayerStatsInterface $b) {
            return $b->getSumLeaguePoints() <=> $a->getSumLeaguePoints();
        });
    }

    /**
     * @param Result[] $results
     */
    protected static function sortResultsByLeaguePoints(array &$results): void
    {
        usort($results, function (Result $a, Result $b) {
            return $b->getLeaguePoints() <=> $a->getLeaguePoints();
        });
    }
}
