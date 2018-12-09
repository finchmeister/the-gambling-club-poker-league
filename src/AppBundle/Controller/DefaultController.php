<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Entity\League;
use AppBundle\League\LeagueTableService;
use AppBundle\PlayerStats\ComputeStats;
use AppBundle\PokerStats\StatsFactory;
use AppBundle\Repository\LeagueRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param LeagueTableService $leagueTableService
     * @param ComputeStats $computeStats
     * @param StatsFactory $playerStatsFactory
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(
        Request $request,
        LeagueTableService $leagueTableService,
        ComputeStats $computeStats,
        StatsFactory $playerStatsFactory
    ) {
        $gameRepository = $this->getDoctrine()
            ->getRepository(Game::class);
        $allGames = $gameRepository->getAllGames();

        /** @var LeagueRepository $leagueRepository */
        $leagueRepository = $this->getDoctrine()
            ->getRepository(League::class);

        /** @var League[] $leagues */
        $leagues = $leagueRepository->findBy([], ['startDate' => 'DESC']);

        $leaguesData = [];
        foreach ($leagues as $league) {
            $leaguesData[] = [
                'league' => $league,
                'leagueGames' => $gameRepository->getLeagueGames($league),
                'leaguePlayersStats' => $playerStatsFactory->getLeaguePlayersStats($league),
                'leaguePlayersTopStats' => $playerStatsFactory->getLeaguePlayersTopStats($league),
                'noOfGamesAllPlayed' => $playerStatsFactory->getNoOfGamesAllPlayed($league),
            ];
        }

        $overallStats = $computeStats->getOverallStats($allGames);

        $allPlayersStats = $playerStatsFactory->getAllPlayersStats();

        return $this->render('default/index.html.twig', [
            'allGames' => $allGames,
            'leaguesData' => $leaguesData,
            'allPlayersStats' => $allPlayersStats,
            'lastUpdated' => $leagueTableService->getLastUpdated(),
            'overallStats' => $overallStats,
        ]);
    }
}
