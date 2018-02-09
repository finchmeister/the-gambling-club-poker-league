<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Player;
use AppBundle\Form\PlayerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Player controller.
 *
 * @Route("admin/player")
 */
class AdminPlayerController extends Controller
{
    /**
     * Lists all player entities.
     *
     * @Route("/", name="admin_player_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $players = $em->getRepository(Player::class)->findAll();

        return $this->render('admin/player/index.html.twig', array(
            'players' => $players,
        ));
    }

    /**
     * Creates a new player entity.
     *
     * @Route("/new", name="player_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('admin_player_index', array('id' => $player->getId()));
        }

        return $this->render('admin/player/new.html.twig', array(
            'player' => $player,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing player entity.
     *
     * @Route("/{id}/edit", name="player_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Player $player
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(
        Request $request,
        Player $player
    ) {
        $deleteFormView = $player->getResults()->count() === 0
            ? $deleteForm = $this->createDeleteForm($player)->createView()
            : null;

        $editForm = $this->createForm(PlayerType::class, $player);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', sprintf(
                "%s updated successfully",
                $player->getName()
            ));

            return $this->redirectToRoute('player_edit', array('id' => $player->getId()));
        }

        return $this->render('admin/player/edit.html.twig', array(
            'player' => $player,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteFormView,
        ));
    }

    /**
     * Deletes a player entity.
     *
     * @Route("/{id}", name="player_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Player $player)
    {
        $form = $this->createDeleteForm($player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($player);
            $em->flush();

            $this->addFlash('danger', sprintf(
                "%s has been deleted",
                $player->getName()
            ));
        }

        return $this->redirectToRoute('admin_player_index');
    }

    /**
     * Creates a form to delete a player entity.
     *
     * @param Player $player The player entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Player $player)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('player_delete', array('id' => $player->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
