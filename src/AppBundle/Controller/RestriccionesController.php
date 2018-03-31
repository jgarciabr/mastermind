<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Restricciones;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Restricciones controller.
 *
 */
class RestriccionesController extends Controller
{
    /**
     * Lists all restricciones entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $restricciones = $em->getRepository('AppBundle:Restricciones')->findAll();

        return $this->render('restricciones/index.html.twig', array(
            'restricciones' => $restricciones,
        ));
    }

    /**
     * Creates a new restricciones entity.
     *
     */
    public function newAction(Request $request)
    {
        $restriccione = new Restricciones();
        $form = $this->createForm('AppBundle\Form\RestriccionesType', $restriccione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($restriccione);
            $em->flush();

            return $this->redirectToRoute('restricciones_show', array('id' => $restriccione->getId()));
        }

        return $this->render('restricciones/new.html.twig', array(
            'restricciones' => $restriccione,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a restricciones entity.
     *
     */
    public function showAction(Restricciones $restriccione)
    {
        $deleteForm = $this->createDeleteForm($restriccione);

        return $this->render('restricciones/show.html.twig', array(
            'restricciones' => $restriccione,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing restricciones entity.
     *
     */
    public function editAction(Request $request, Restricciones $restriccione)
    {
        $deleteForm = $this->createDeleteForm($restriccione);
        $editForm = $this->createForm('AppBundle\Form\RestriccionesType', $restriccione);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('restricciones_edit', array('id' => $restriccione->getId()));
        }

        return $this->render('restricciones/edit.html.twig', array(
            'restricciones' => $restriccione,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a restricciones entity.
     *
     */
    public function deleteAction(Request $request, Restricciones $restriccione)
    {
        $form = $this->createDeleteForm($restriccione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($restriccione);
            $em->flush();
        }

        return $this->redirectToRoute('restricciones_index');
    }

    /**
     * Creates a form to delete a restricciones entity.
     *
     * @param Restricciones $restriccione The restricciones entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Restricciones $restriccione)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('restricciones_delete', array('id' => $restriccione->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
