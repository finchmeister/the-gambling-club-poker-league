<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\League\LeagueTableService;
use AppBundle\PlayerStats\ComputeStats;
use AppBundle\PokerStats\StatsFactory;
use Doctrine\Common\Collections\ArrayCollection;
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
        // TODO refactor into services
        $em = $this->getDoctrine();
        $allGames = $em->getRepository(Game::class)
            ->findBy([], ['date' => 'DESC']);
        $allGames = new ArrayCollection($allGames);
        $leagueGames = $allGames->filter(function (Game $game) {
            return $game->isLeague();
        });

        // TODO look at overall stats implementation
        $overallStats = $computeStats->getOverallStats($allGames);

        $allPlayersStats = $playerStatsFactory->getAllPlayersStats();
        $leaguePlayersStats = $playerStatsFactory->getLeaguePlayersStats();

        $leagueTable = $leagueTableService->getLeagueTable();
        return $this->render('default/index.html.twig', [
            'allGames' => $allGames,
            'leagueGames' => $leagueGames,
            'leagueTable' => $leagueTable,
            'allPlayersStats' => $allPlayersStats,
            'leaguePlayersStats' => $leaguePlayersStats,
            'lastUpdated' => $leagueTableService->getLastUpdated(),
            'overallStats' => $overallStats,
        ]);
    }
}
