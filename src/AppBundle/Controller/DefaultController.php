<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\League\LeagueTableService;
use AppBundle\PlayerStats\ComputeStats;
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(
        Request $request,
        LeagueTableService $leagueTableService,
        ComputeStats $computeStats
    ) {
        // TODO refactor into services
        $em = $this->getDoctrine();
        $games = $em->getRepository(Game::class)
            ->findAll();

        $overallStats = $computeStats->getOverallStats(new ArrayCollection($games));

        $leagueTable = $leagueTableService->getLeagueTable();
        return $this->render('default/index.html.twig', [
            'games' => $games,
            'leagueTable' => $leagueTable,
            'lastUpdated' => $leagueTableService->getLastUpdated(),
            'overallStats' => $overallStats,
        ]);
    }
}
