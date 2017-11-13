<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Player;
use AppBundle\League\PlayerService;
use AppBundle\PlayerStats\ComputePlayerStats;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Player controller.
 *
 * @Route("/player")
 */
class PlayerController extends Controller
{
    /**
     * Lists all player entities.
     *
     * @Route("/", name="player_index")
     * @Method("GET")
     * @param PlayerService $playerService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(PlayerService $playerService)
    {
        $em = $this->getDoctrine()->getManager();

        $players = $em->getRepository(Player::class)->findAll();



        return $this->render('player/index.html.twig', array(
            'players' => $players,
        ));
    }

    /**
     * @Route("/{id}", name="player_show")
     * @Method("GET")
     * @param Player $player
     * @param PlayerService $playerService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(
        Player $player,
        PlayerService $playerService,
        ComputePlayerStats $computePlayerStats
    ) {
        dump($player->getResults()->count());
        // Get stats.

        //  getPlayerStats($player)

        dump($playerService->getPlayerWinLoseStats($player));

        //playerStats->getPlayerStats($player);


        return $this->render('player/show.html.twig', array(
            'player' => $player,
        ));
    }

}