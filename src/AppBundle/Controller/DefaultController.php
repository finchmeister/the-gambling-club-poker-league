<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Entity\League;
use AppBundle\League\LeagueTableService;
use AppBundle\PlayerStats\ComputeStats;
use AppBundle\PokerStats\StatsFactory;
use AppBundle\Repository\GameRepository;
use AppBundle\Repository\LeagueRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Predis;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @var LeagueTableService
     */
    private $leagueTableService;
    /**
     * @var ComputeStats
     */
    private $computeStats;
    /**
     * @var StatsFactory
     */
    private $playerStatsFactory;

    public function __construct(
        LeagueTableService $leagueTableService,
        ComputeStats $computeStats,
        StatsFactory $playerStatsFactory
    ) {
        $this->leagueTableService = $leagueTableService;
        $this->computeStats = $computeStats;
        $this->playerStatsFactory = $playerStatsFactory;
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
        return $this->render('default/index.html.twig', $this->getData());
    }

    private function getData(): array
    {
        // TODO, own service
        $client = new Predis\Client([
            'host'   => 'redis',
        ]);

        $data = $client->get('indexData');

        if ($data === null) {
            $client->set('indexData', $this->computeData());
        }

        return $data;
    }

    private function computeData(): array
    {
        /** @var GameRepository $gameRepository */
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
                'leaguePlayersStats' => $this->playerStatsFactory->getLeaguePlayersStats($league),
                'leaguePlayersTopStats' => $this->playerStatsFactory->getLeaguePlayersTopStats($league),
                'noOfGamesAllPlayed' => $this->playerStatsFactory->getNoOfGamesAllPlayed($league),
            ];
        }

        $overallStats = $this->computeStats->getOverallStats($allGames);
        $allPlayersStats = $this->playerStatsFactory->getAllPlayersStats();

        return [
            'allGames' => $allGames,
            'leaguesData' => $leaguesData,
            'allPlayersStats' => $allPlayersStats,
            'lastUpdated' => $this->leagueTableService->getLastUpdated(),
            'overallStats' => $overallStats,
        ];
    }
}
