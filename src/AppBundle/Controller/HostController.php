<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use AppBundle\PokerStats\StatsFactory;
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
     * @param Player $host
     * @param StatsFactory $statsFactory
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(
        Player $host,
        StatsFactory $statsFactory
    ) {

        $hostStats = $statsFactory->getHostStats($host);

        $em = $this->getDoctrine();

        $games = $em->getRepository(Game::class)
            ->findBy(['host' => $host], ['date' => 'DESC']);
        return $this->render('host/show.html.twig', array(
            'host' => $host,
            'hostStats' => $hostStats,
            'games' => $games,
        ));
    }

}