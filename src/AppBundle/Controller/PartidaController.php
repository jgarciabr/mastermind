<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Partida;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


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
        //Recuperamos solo las partidas que están en juego
        $partidas = $em->getRepository('AppBundle:Partida')->findBy(array('state' => 'En juego'));

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
            $partida->setNumsessions(0);
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
                    $codigo = $codigo.",".$colores[$valor];
                }else{
                    $codigo = $colores[$valor];
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
     * Creates a new partida entity.
     *
     */
    public function addAction(Request $request)
    {
        $partida = new Partida();


        if($partida->getName()==""){
                $partida->setName("partida".time());
            }

            //TO DO, recoger valor de la tabla restricciones
            $partida->setNumsessions(0);
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
                    $codigo = $codigo.",".$colores[$valor];
                }else{
                    $codigo = $colores[$valor];
                }
            }
            $partida->setCode($codigo);
            $em = $this->getDoctrine()->getManager();
            $em->persist($partida);
            $em->flush();


        if($partida->getId()>0) {
            $response = new Response(json_encode(array(
                'state' => $partida->getState(),
                'numsessions' => (15 - $partida->getNumsessions()),
                'code' => $partida->getCode()
            )));
            $response->setStatusCode(Response::HTTP_CREATED);
            $response->headers->set('Content-Type', 'application/json');
        }else {

            // crea una respuesta JSON con código de estado 417
            $response = new Response(json_encode(array(
                'ERROR' => 'No se ha podido crear el registro',
            )));
            $response->setStatusCode(Response::HTTP_EXPECTATION_FAILED);
            $response->headers->set('Content-Type', 'application/json');

        }
        return $response;
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
     * Finds and displays a jugada entity.
     *
     * @Route("/{id}", name="jugada_show")
     * @Method("GET")
     */
    public function getPartidaAction(Request $request)
    {
        $id = $request->query->get('id');

        $partida = $this->getDoctrine()
            ->getRepository(Partida::class)
            ->find($id);


        // crea una respuesta JSON con código de estado 200
        $response = new Response(json_encode(array(
            'id' => $partida->getId(),
            'date' => $partida->getDate(),
            'code' => $partida->getCode(),
            'state' => $partida->getState(),
            'jugadas' => $partida->getNumsessions()
        )));
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
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
