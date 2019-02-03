<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\League;
use AppBundle\Form\LeagueType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("admin/league")
 */
class AdminLeagueController extends Controller
{
    /**
     * @Route("/", name="admin_league_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $leagues = $em->getRepository(League::class)->findAll();

        return $this->render('admin/league/index.html.twig', array(
            'leagues' => $leagues,
        ));
    }

    /**
     * @Route("/new", name="league_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $league = new League();
        $form = $this->createForm(LeagueType::class, $league);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($league);
            $em->flush();

            return $this->redirectToRoute('admin_player_index', array('id' => $league->getId()));
        }

        return $this->render('admin/league/new.html.twig', array(
            'league' => $league,
            'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/{id}/edit", name="league_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param League $league
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(
        Request $request,
        League $league
    ) {
        $deleteFormView = $this->createDeleteForm($league)->createView();

        $editForm = $this->createForm(LeagueType::class, $league);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', sprintf(
                "%s updated successfully",
                'League'
            ));

            return $this->redirectToRoute('league_edit', array('id' => $league->getId()));
        }

        return $this->render('admin/league/edit.html.twig', array(
            'league' => $league,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteFormView,
        ));
    }

    /**
     * @Route("/{id}", name="league_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, League $league)
    {
        $form = $this->createDeleteForm($league);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($league);
            $em->flush();

            $this->addFlash('danger', sprintf(
                "%s has been deleted",
                $league->getId()
            ));
        }

        return $this->redirectToRoute('admin_league_index');
    }

    /**
     * @param League $league
     * @return FormInterface
     */
    private function createDeleteForm(League $league): FormInterface
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('league_delete', array('id' => $league->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
