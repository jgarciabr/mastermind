<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Jugada;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Jugada controller.
 *
 * @Route("jugada")
 */
class JugadaController extends Controller
{
    /**
     * Lists all jugada entities.
     *
     * @Route("/", name="jugada_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $jugadas = $em->getRepository('AppBundle:Jugada')->findAll();

        return $this->render('jugada/index.html.twig', array(
            'jugadas' => $jugadas,
        ));
    }

    /**
     * Creates a new jugada entity.
     *
     * @Route("/new", name="jugada_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $jugada = new Jugada();
        $form = $this->createForm('AppBundle\Form\JugadaType', $jugada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jugada);
            $em->flush();

            return $this->redirectToRoute('jugada_show', array('id' => $jugada->getId()));
        }

        return $this->render('jugada/new.html.twig', array(
            'jugada' => $jugada,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a jugada entity.
     *
     * @Route("/{id}", name="jugada_show")
     * @Method("GET")
     */
    public function showAction(Jugada $jugada)
    {
        $deleteForm = $this->createDeleteForm($jugada);

        return $this->render('jugada/show.html.twig', array(
            'jugada' => $jugada,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing jugada entity.
     *
     * @Route("/{id}/edit", name="jugada_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Jugada $jugada)
    {
        $deleteForm = $this->createDeleteForm($jugada);
        $editForm = $this->createForm('AppBundle\Form\JugadaType', $jugada);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jugada_edit', array('id' => $jugada->getId()));
        }

        return $this->render('jugada/edit.html.twig', array(
            'jugada' => $jugada,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a jugada entity.
     *
     * @Route("/{id}", name="jugada_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Jugada $jugada)
    {
        $form = $this->createDeleteForm($jugada);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($jugada);
            $em->flush();
        }

        return $this->redirectToRoute('jugada_index');
    }

    /**
     * Creates a form to delete a jugada entity.
     *
     * @param Jugada $jugada The jugada entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Jugada $jugada)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jugada_delete', array('id' => $jugada->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
