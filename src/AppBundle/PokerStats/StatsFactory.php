<?php


namespace AppBundle\PokerStats;

use AppBundle\Entity\Game;
use AppBundle\Entity\League;
use AppBundle\Entity\Player;
use AppBundle\Entity\Result;
use AppBundle\Repository\GameRepository;
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
    /** @var GameRepository  */
    private $gameRepository;
    /** @var \AppBundle\Repository\ResultRepository */
    private $resultDocRepository;

    public function __construct(
        ResultRepository $resultRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->resultRepository = $resultRepository;
        $this->entityManager = $entityManager;
        $this->playerRepository = $this->entityManager
            ->getRepository(Player::class);
        $this->gameRepository = $this->entityManager
            ->getRepository(Game::class);
        $this->resultDocRepository = $this->entityManager
            ->getRepository(Result::class);
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

    public function getLeaguePlayerStats(Player $player, League $league): PlayerStatsInterface
    {
        $results = $this->resultDocRepository->getPlayersLeagueResults(
            $player,
            $league
        );

        $playerStats = $this->initialisePlayerStats($player);
        return $playerStats->setResults(new ArrayCollection($results));
    }


    public function getLeaguePlayerTopStats(
        Player $player,
        int $noOfResults,
        League $league
    ): PlayerStatsInterface {
        $results = $this->resultDocRepository->getPlayersLeagueResults(
            $player,
            $league
        );
        self::sortResultsByLeaguePoints($results);
        $reducedResults = new ArrayCollection();
        if ($noOfResults > count($results)) {
            throw new \RuntimeException('Attempting to get too many top results');
        }
        foreach (range(0, $noOfResults - 1) as $i) {
            $reducedResults->add($results[$i]);
        }
        $playerStats = $this->initialisePlayerStats($player);
        return $playerStats->setResults($reducedResults);
    }

    public function getHostStats(Player $host): HostStats
    {
        $games = $this->gameRepository
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
     * @param League $league
     * @return PlayerStatsInterface[]
     */
    public function getLeaguePlayersStats(League $league): array
    {
        $leaguePlayersStats = [];
        $players = $league->getPlayers();
        foreach ($players as $player) {
            $leaguePlayersStats[] = $this->getLeaguePlayerStats($player, $league);
        }
        self::sortPlayerStatsByLeaguePoints($leaguePlayersStats);
        return $leaguePlayersStats;
    }

    /**
     * @param League $league
     * @return PlayerStatsInterface[]
     */
    public function getLeaguePlayersTopStats(League $league): array
    {
        $leaguePlayersTopStats = [];
        $players = $league->getPlayers();
        $noOfGamesAllPlayed = $this->getNoOfGamesAllPlayed($league);
        foreach ($players as $player) {
            $leaguePlayersTopStats[] = $this->getLeaguePlayerTopStats(
                $player,
                $noOfGamesAllPlayed,
                $league
            );
        }
        self::sortPlayerStatsByLeaguePoints($leaguePlayersTopStats);
        return $leaguePlayersTopStats;
    }

    /**
     * @param League $league
     * @return int
     */
    public function getNoOfGamesAllPlayed(League $league): int
    {
        return $this->playerRepository->getNoOfGamesAllPlayed($league);
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
