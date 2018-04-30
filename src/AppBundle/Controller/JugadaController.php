<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Jugada;
use AppBundle\Entity\Partida;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



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
            $jugada->setDate(date_create());

            $em = $this->getDoctrine()->getManager();
            $id = $request->query->get('partidaid');
            //Recuperamos la partida
            $partida = $this->getDoctrine()
                ->getRepository(Partida::class)
                ->find($id);
            //Comprobamos código introducido
            $codigo_correcto = $partida->getCode();

            $valores = explode(",",$codigo_correcto);

            $resultado = "";
                if($valores[0]==$jugada->getCode1()){
                    $jugada->setCode1("Negra");
                }else{
                    $jugada->setCode1("Blanca");
                }
                $resultado.=$jugada->getCode1();

        if($valores[1]==$jugada->getCode2()){
            $jugada->setCode2("Negra");
        }else{
            $jugada->setCode2("Blanca");
        }
        $resultado.=$jugada->getCode2();

        if($valores[2]==$jugada->getCode3()){
            $jugada->setCode3("Negra");
        }else{
            $jugada->setCode3("Blanca");
        }
        $resultado.=$jugada->getCode3();

        if($valores[3]==$jugada->getCode4()){
            $jugada->setCode4("Negra");
        }else{
            $jugada->setCode4("Blanca");
        }
        $resultado.=$jugada->getCode4();

        if($valores[4]==$jugada->getCode5()){
            $jugada->setCode5("Negra");
        }else{
            $jugada->setCode5("Blanca");
        }
        $resultado.=$jugada->getCode5();

        if($valores[5]==$jugada->getCode6()){
            $jugada->setCode6("Negra");
        }else{
            $jugada->setCode6("Blanca");
        }
        $resultado.=$jugada->getCode6();


            $jugada->setResult($resultado);
            //si ya hemos llegado al número máximo de jugadas devolvemos error

            if($partida->getNumsessions()>=15){
                $partida->setState("Partida finalizada con derrota");
                $jugada->setPartida($partida);
                $em->persist($jugada);
                $em->flush();
                $response = new Response(
                    'Ha alcanzado el número máximo de jugadas',
                    Response::HTTP_OK,
                    array('content-type' => 'text/html')
                );
                return $response;

            }


            $jugada->setPartida($partida);
            $em->persist($jugada);



            $em->persist($partida);
            $em->flush();


            return $this->redirectToRoute('jugada_show', array('id' => $jugada->getId()));
        }

        return $this->render('jugada/new.html.twig', array(
            'jugada' => $jugada,
            'form' => $form->createView(),
        ));
    }



    /**
     * Creates a new jugada entity.
     *
     * @Route("/add", name="jugada_new")
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $jugada = new Jugada();
        $jugada->setDate(date_create());

        $em = $this->getDoctrine()->getManager();
        $id = $request->query->get('partidaid');

        //Recuperamos la partida
        $partida = $this->getDoctrine()
            ->getRepository(Partida::class)
            ->find($id);

        if(!$partida){
            $response = new Response(json_encode(array(
                "Error"=>"No se ha encontrado la partida")));
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            $response->headers->set('Content-Type', 'application/json');
            return $response;

        }
        //Comprobamos código introducido
        $codigo_correcto = $partida->getCode();

        $valores = explode(",",$codigo_correcto);
        $resultado = "";
        if($valores[0]==$request->query->get('code1')){
            $jugada->setCode1("Negra");
        }else{
            $jugada->setCode1("Blanca");
        }
        $resultado.=$jugada->getCode1();

        if($valores[1]==$request->query->get('code2')){
            $jugada->setCode2("Negra");
        }else{
            $jugada->setCode2("Blanca");
        }
        $resultado.=$jugada->getCode2();

        if($valores[2]==$request->query->get('code3')){
            $jugada->setCode3("Negra");
        }else{
            $jugada->setCode3("Blanca");
        }
        $resultado.=$jugada->getCode3();

        if($valores[3]==$request->query->get('code4')){
            $jugada->setCode4("Negra");
        }else{
            $jugada->setCode4("Blanca");
        }
        $resultado.=$jugada->getCode4();

        if($valores[4]==$request->query->get('code5')){
            $jugada->setCode5("Negra");
        }else{
            $jugada->setCode5("Blanca");
        }
        $resultado.=$jugada->getCode5();

        if($valores[5]==$request->query->get('code6')){
            $jugada->setCode6("Negra");
        }else{
            $jugada->setCode6("Blanca");
        }
        $resultado.=$jugada->getCode6();


        $jugada->setResult($resultado);
        //si ya hemos llegado al número máximo de jugadas devolvemos error

        if($partida->getNumsessions()>=15){
            $partida->setState("Partida finalizada con derrota");
            $jugada->setPartida($partida);
            $partida->setNumsessions = $partida->getNumsessions()+1;
            $em->persist($jugada);
            $em->flush();

            $em->persist($partida);
            $em->flush();

            $response = new Response(json_encode(array(
                "Error"=>"Ya ha realizado el máximo número de jugadas posibles en esta partida",
                "state"=>$partida->getState()
            )));
            $response->setStatusCode(Response::HTTP_LOCKED);
            $response->headers->set('Content-Type', 'application/json');
            return $response;



            if($jugada->getId()>0) {
                $response = new Response(json_encode(array(
                    'state' => $partida->getState(),
                    'numsessions' => (15 - $partida->getNumsessions()),
                    'code' => $partida->getCode()
                )));
                $response->setStatusCode(Response::HTTP_CREATED);
                $response->headers->set('Content-Type', 'application/json');
            }else{
                // crea una respuesta JSON con código de estado 417
                $response = new Response(json_encode(array(
                    'ERROR' => 'No se ha podido crear el registro',
                )));
                $response->setStatusCode(Response::HTTP_EXPECTATION_FAILED);
                $response->headers->set('Content-Type', 'application/json');
            }

            return $response;
        }


        $jugada->setPartida($partida);
        $em->persist($jugada);
        $em->flush();

        $partida->setNumsessions($partida->getNumsessions()+1);
        $em->persist($partida);
        $em->flush();

        $response = new Response(json_encode(array(
            "Result"=>$jugada->getResult(),
            "state"=>$partida->getState(),
            "Jugadas restantes"=>(15-$partida->getNumsessions())
            )));
        $response->setStatusCode(Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
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
         * Finds and displays a jugada entity.
         *
         * @Route("/{id}", name="getJugada")
         * @Method("GET")
         */
        public function getJugadaAction(Request $request)
        {
            $id = $request->query->get('id');

                        $jugada = $this->getDoctrine()
                            ->getRepository(Jugada::class)
                            ->find($id);
                     $json = json_encode(array(
                         'id' => $jugada->getId(),
                         'date' => $jugada->getDate(),
                         'code1' => $jugada->getCode1(),
                         'code2' => $jugada->getCode2(),
                         'code3' => $jugada->getCode3(),
                         'code4' => $jugada->getCode4(),
                         'code5' => $jugada->getCode5(),
                         'code6' => $jugada->getCode5(),
                         'result' => $jugada->getResult(),
                         'partida' => $jugada->getPartidaId(),

                     ), JSON_FORCE_OBJECT);


            $response = new Response(
                $json,
                Response::HTTP_OK,
                array('content-type' => 'text/html')
            );
            return $response;
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
