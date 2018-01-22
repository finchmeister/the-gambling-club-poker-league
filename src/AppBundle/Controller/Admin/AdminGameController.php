<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Game;
use AppBundle\Form\GameType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Game controller.
 *
 * @Route("/admin/game")
 */
class AdminGameController extends Controller
{
    /**
     * Lists all game entities.
     *
     * @Route("/", name="game_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $games = $em->getRepository('AppBundle:Game')->findAll();

        return $this->render('admin/game/index.html.twig', array(
            'games' => $games,
        ));
    }

    /**
     * Creates a new game entity.
     *
     * @Route("/new", name="game_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('game_index');
        }

        return $this->render('admin/game/new.html.twig', array(
            'game' => $game,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing game entity.
     *
     * @Route("/{id}/edit", name="game_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Game $game)
    {
        $originalResults = new ArrayCollection();

        foreach ($game->getResults() as $result) {
            $originalResults->add($result);
        }

        $deleteForm = $this->createDeleteForm($game);
        $editForm = $this->createForm(GameType::class, $game);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Tidy up results
            foreach ($originalResults as $result) {
                if ($game->getResults()->contains($result) === false) {
                    $result->setGame(null);
                    $em->remove($result);
                }
            }

            $em->flush();
            $this->addFlash('success', 'Game updated successfully');

            return $this->redirectToRoute('game_edit', array('id' => $game->getId()));
        }

        dump($game);
        return $this->render('admin/game/edit.html.twig', array(
            'game' => $game,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a game entity.
     *
     * @Route("/{id}", name="game_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Game $game)
    {
        $form = $this->createDeleteForm($game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $gameId = $game->getId();
            $em->remove($game);
            $em->flush();

            $this->addFlash('danger', sprintf(
                "Game id: %s has been deleted",
                $gameId
            ));
        }

        return $this->redirectToRoute('game_index');
    }

    /**
     * Creates a form to delete a game entity.
     *
     * @param Game $game The game entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Game $game)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('game_delete', array('id' => $game->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
