<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Game;
use AppBundle\Entity\Player;
use AppBundle\PokerStats\StatsFactory;
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
     * @param StatsFactory $playerStatsFactory
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param PlayerService $playerService
     */
    public function indexAction(StatsFactory $playerStatsFactory)
    {
        $em = $this->getDoctrine()->getManager();

        $players = $em->getRepository(Player::class)->getDisplayedPlayers();

        foreach ($players as $player) {
            $player->setPlayerStats(
                $playerStatsFactory->getAllPlayerStats($player)
            );
        }

        return $this->render('player/index.html.twig', array(
            'players' => $players,
        ));
    }

    /**
     * @Route("/{id}", name="player_show")
     * @Method("GET")
     * @param Player $player
     * @param StatsFactory $playerStatsFactory
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param PlayerService $playerService
     */
    public function showAction(
        Player $player,
        StatsFactory $playerStatsFactory
    ) {

        $player->setPlayerStats($playerStatsFactory->getAllPlayerStats($player));

        $em = $this->getDoctrine();
        $playersGames = $em->getRepository(Game::class)->getAllPlayersGames($player);

        return $this->render('player/show.html.twig', array(
            'player' => $player,
            'playersGames' => $playersGames,
        ));
    }

}