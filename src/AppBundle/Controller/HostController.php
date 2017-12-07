<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Player;
use AppBundle\League\PlayerService;
use AppBundle\PlayerStats\ComputePlayerStats;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Host controller.
 *
 * @Route("/host")
 */
class HostController extends Controller
{

    /**
     * @Route("/{id}", name="host_show")
     * @Method("GET")
     * @param Player $player
     * @param ComputePlayerStats $computePlayerStats
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param PlayerService $playerService
     */
    public function showAction(
        Player $player,
        ComputePlayerStats $computePlayerStats
    ) {

        $allPlayerStats = $computePlayerStats->getAllPlayerStats($player);

        return $this->render('host/show.html.twig', array(
            'host' => $player,
            'allPlayerStats' => $allPlayerStats
        ));
    }

}