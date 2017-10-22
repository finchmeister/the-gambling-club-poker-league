<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Result;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Result controller.
 *
 * @Route("admin/")
 */
class ResultController extends Controller
{
    /**
     * Lists all result entities.
     *
     * @Route("/", name="result_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $results = $em->getRepository('AppBundle:Result')->findAll();

        return $this->render('result/index.html.twig', array(
            'results' => $results,
        ));
    }

    /**
     * Creates a new result entity.
     *
     * @Route("/new", name="result_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $result = new Result();
        $form = $this->createForm('AppBundle\Form\ResultType', $result);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($result);
            $em->flush();

            return $this->redirectToRoute('result_show', array('id' => $result->getId()));
        }

        return $this->render('result/new.html.twig', array(
            'result' => $result,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a result entity.
     *
     * @Route("/{id}", name="result_show")
     * @Method("GET")
     */
    public function showAction(Result $result)
    {
        $deleteForm = $this->createDeleteForm($result);

        return $this->render('result/show.html.twig', array(
            'result' => $result,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing result entity.
     *
     * @Route("/{id}/edit", name="result_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Result $result)
    {
        $deleteForm = $this->createDeleteForm($result);
        $editForm = $this->createForm('AppBundle\Form\ResultType', $result);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('result_edit', array('id' => $result->getId()));
        }

        return $this->render('result/edit.html.twig', array(
            'result' => $result,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a result entity.
     *
     * @Route("/{id}", name="result_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Result $result)
    {
        $form = $this->createDeleteForm($result);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($result);
            $em->flush();
        }

        return $this->redirectToRoute('result_index');
    }

    /**
     * Creates a form to delete a result entity.
     *
     * @param Result $result The result entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Result $result)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('result_delete', array('id' => $result->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
