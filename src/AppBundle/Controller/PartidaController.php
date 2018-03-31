<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Partida;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Partida controller.
 *
 */
class PartidaController extends Controller
{
    /**
     * Lists all partida entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $partidas = $em->getRepository('AppBundle:Partida')->findAll();

        return $this->render('partida/index.html.twig', array(
            'partidas' => $partidas,
        ));
    }

    /**
     * Creates a new partida entity.
     *
     */
    public function newAction(Request $request)
    {
        $partida = new Partida();
        $form = $this->createForm('AppBundle\Form\PartidaType', $partida);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            if($partida->getName()==""){
                $partida->setName("partida".time());
            }

            //TO DO, recoger valor de la tabla restricciones
            $partida->setNumsessions(15);
            $partida->setState("En juego");
            $partida->setDate(date_create());

            //CREAMOS CÓDIGO COLOR ALEATORIO
            $colores = array("negro","naranja","marron","rojo","blanco","azul","verde","amarillo","rosa","morado");
            $valores = array_rand($colores,6);
            $codigo = "";
            $count=0;
            foreach ($valores as $valor){
                $count++;
                if($count>1){
                    $codigo = $codigo.",".$valor;
                }else{
                    $codigo = $valor;
                }
            }
            $partida->setCode($codigo);
            $em = $this->getDoctrine()->getManager();
            $em->persist($partida);
            $em->flush();

            return $this->redirectToRoute('partida_show', array('id' => $partida->getId()));
        }

        return $this->render('partida/new.html.twig', array(
            'partida' => $partida,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a partida entity.
     *
     */
    public function showAction(Partida $partida)
    {
        $deleteForm = $this->createDeleteForm($partida);

        return $this->render('partida/show.html.twig', array(
            'partida' => $partida,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing partida entity.
     *
     */
    public function editAction(Request $request, Partida $partida)
    {
        $deleteForm = $this->createDeleteForm($partida);
        $editForm = $this->createForm('AppBundle\Form\PartidaType', $partida);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partida_edit', array('id' => $partida->getId()));
        }

        return $this->render('partida/edit.html.twig', array(
            'partida' => $partida,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a partida entity.
     *
     */
    public function deleteAction(Request $request, Partida $partida)
    {
        $form = $this->createDeleteForm($partida);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($partida);
            $em->flush();
        }

        return $this->redirectToRoute('partida_index');
    }

    /**
     * Creates a form to delete a partida entity.
     *
     * @param Partida $partida The partida entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Partida $partida)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partida_delete', array('id' => $partida->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
