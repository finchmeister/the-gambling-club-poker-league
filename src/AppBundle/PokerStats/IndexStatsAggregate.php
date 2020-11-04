<?php declare(strict_types=1);

namespace AppBundle\PokerStats;

use AppBundle\Cache\CacheManager;
use AppBundle\Entity\League;
use AppBundle\League\LeagueTableService;
use AppBundle\PlayerStats\OverallStatsFactory;
use AppBundle\Repository\GameRepository;
use AppBundle\Repository\LeagueRepository;

class IndexStatsAggregate
{
    public const CACHE_KEY = 'index_stats';

    /**
     * @var LeagueTableService
     */
    private $leagueTableService;
    /**
     * @var OverallStatsFactory
     */
    private $overallStatsFactory;
    /**
     * @var StatsFactory
     */
    private $playerStatsFactory;
    /**
     * @var GameRepository
     */
    private $gameRepository;
    /**
     * @var LeagueRepository
     */
    private $leagueRepository;
    /**
     * @var CacheManager
     */
    private $cacheManager;


    public function __construct(
        LeagueTableService $leagueTableService,
        OverallStatsFactory $overallStatsFactory,
        StatsFactory $playerStatsFactory,
        GameRepository $gameRepository,
        LeagueRepository $leagueRepository,
        CacheManager $cacheManager
    ) {
        $this->leagueTableService = $leagueTableService;
        $this->overallStatsFactory = $overallStatsFactory;
        $this->playerStatsFactory = $playerStatsFactory;
        $this->gameRepository = $gameRepository;
        $this->leagueRepository = $leagueRepository;
        $this->cacheManager = $cacheManager;
    }

    public function getData(): array
    {
        return $this->cacheManager->getCachedOrCompute(self::CACHE_KEY, function () {
            return $this->computeData();
        });
    }

    private function computeData(): array
    {
        $allGames = $this->gameRepository->getAllGames();

        /** @var League[] $leagues */
        $leagues = $this->leagueRepository->findBy([], ['startDate' => 'DESC']);
        $leaguesData = [];
        foreach ($leagues as $league) {
            $leaguesData[] = [
                'league' => $league,
                'leagueGames' => $this->gameRepository->getLeagueGames($league),
                'leaguePlayersStats' => $this->playerStatsFactory->getLeaguePlayersStats($league),
                'leaguePlayersTopStats' => $this->playerStatsFactory->getLeaguePlayersTopStats($league),
                'noOfGamesAllPlayed' => $this->playerStatsFactory->getNoOfGamesAllPlayed($league),
            ];
        }

        $onlineGames = $this->gameRepository->getAllOnlineGames();

        $overallStats = $this->overallStatsFactory->getOverallStats($allGames);
        $onlineOverallStats = $this->overallStatsFactory->getOverallStats($onlineGames);

        $allPlayersStats = $this->playerStatsFactory->getAllPlayersStats();
        $onlinePlayersStats = $this->playerStatsFactory->getOnlinePlayersStats();

        return [
            'allGames' => $allGames,
            'onlineGames' => $onlineGames,
            'leaguesData' => $leaguesData,
            'allPlayersStats' => $allPlayersStats,
            'onlinePlayersStats' => $onlinePlayersStats,
            'lastUpdated' => $this->leagueTableService->getLastUpdated(),
            'overallStats' => $overallStats,
            'onlineOverallStats' => $onlineOverallStats,
        ];
    }
}
