<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Player;
use AppBundle\League\PlayerService;
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


        dump($playerService->getAllPlayersWinLoseStats());

        return $this->render('player/index.html.twig', array(
            'players' => $players,
        ));
    }

    /**
     * Lists all player entities.
     *
     * @Route("/{id}", name="player_show")
     * @Method("GET")
     * @param Player $player
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Player $player)
    {
        return $this->render('player/show.html.twig', array(
            'player' => $player,
        ));
    }

}