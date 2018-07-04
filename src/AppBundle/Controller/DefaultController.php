<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\League\LeagueTableService;
use AppBundle\PlayerStats\ComputeStats;
use AppBundle\PokerStats\StatsFactory;
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
        $leagueGames = $allGames->filter(function (Game $game) {
            return $game->isLeague();
        });
        $overallStats = $computeStats->getOverallStats($allGames);

        $allPlayersStats = $playerStatsFactory->getAllPlayersStats();
        $leaguePlayersTopStats = $playerStatsFactory->getLeaguePlayersTopStats();
        $leaguePlayersStats = $playerStatsFactory->getLeaguePlayersStats();
        $noOfGamesAllPlayed = $playerStatsFactory->getNoOfGamesAllPlayed();

        return $this->render('default/index.html.twig', [
            'allGames' => $allGames,
            'leagueGames' => $leagueGames,
            'allPlayersStats' => $allPlayersStats,
            'leaguePlayersStats' => $leaguePlayersStats,
            'leaguePlayersTopStats' => $leaguePlayersTopStats,
            'noOfGamesAllPlayed' => $noOfGamesAllPlayed,
            'lastUpdated' => $leagueTableService->getLastUpdated(),
            'overallStats' => $overallStats,
        ]);
    }
}
