<?php

namespace AppBundle\Controller;

use AppBundle\League\LeagueTableService;
use AppBundle\PlayerStats\ComputeStats;
use AppBundle\PokerStats\IndexStatsAggregate;
use AppBundle\PokerStats\StatsFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @var IndexStatsAggregate
     */
    private $indexStatsAggregate;

    public function __construct(
        IndexStatsAggregate $indexStatsAggregate
    ) {
        $this->indexStatsAggregate = $indexStatsAggregate;
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param LeagueTableService $leagueTableService
     * @param ComputeStats $computeStats
     * @param StatsFactory $playerStatsFactory
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(): Response
    {
        return $this->render('default/index.html.twig', $this->indexStatsAggregate->getData());
    }
}
