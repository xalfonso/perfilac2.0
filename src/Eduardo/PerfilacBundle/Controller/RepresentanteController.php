<?php

namespace Eduardo\PerfilacBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduardo\PerfilacBundle\Entity\Cliente;
use Eduardo\PerfilacBundle\Entity\Representante;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Eduardo\PerfilacBundle\Util\Estandar;

/**
 * Controlador para el representante
 * @author Eduardo Alfonso <eddie.alfonso@gmail.com>
 */
class RepresentanteController extends Controller {

    public function incluirAction($accion) {

        #cargo los clientes
        $clientes = $this->listarClientes();

        #para comenzar a insertar 
        $msg = "";
        if ($accion == 'ini')
            return $this->render('PerfilacBundle:cliente:incluirRepresentante.html.twig', array('msg' => $msg, 'clientes' => $clientes));

        #para procesar los datos insertados
        if ($accion == 'ej') {
            #verificar que no acceda a la url sin insertar los datos         
            $request = Request::createFromGlobals();
            $boton = $request->request->get('enviar');
            if (!$boton) {
                $msg = Estandar::msg_DebeDatos;
            } else {
                #para procesar los datos insertados
                $nombre = $request->request->get('name_nombre');
                $snombre = $request->request->get('name_snombre');
                $apellido = $request->request->get('name_apellido');
                $sapellido = $request->request->get('name_sapellido');
                $ci = $request->request->get('name_ci');
                $te = $request->request->get('name_telefono');
                $correo = $request->request->get('name_correo');
                $cargo = $request->request->get('name_cargo');
                $idCliente = $request->request->get('name_clientes');
                $cliente = $this->obtenerCliente($idCliente);

                $this->salvar($nombre, $snombre, $apellido, $sapellido, $ci, $te, $correo,$cargo, $cliente);
                $msg = Estandar::msg_DatosIncluidos;
            }

            return $this->render('PerfilacBundle:cliente:incluirRepresentante.html.twig', array('msg' => $msg, 'clientes' => $clientes));
        }

        #si no cumple con ninguno de los parametros lo redirecciono para el inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function modificarAction($id) {

        $msg = "";
        $representante = $this->obtener($id);
        if ($representante != NULL) {
            #cargo los clientes
            $clientes = $this->listarClientes();
            return $this->render('PerfilacBundle:cliente:modificarRepresentante.html.twig', array('msg' => $msg, 'representante' => $representante, 'clientes' => $clientes));
        } else {
            #en caso que no exista un objeto con tal id redirecciono para el listar
            return new RedirectResponse($this->generateUrl('representanteListar'));
        }
    }

    public function actualizarAction($id) {

        #verificar que no acceda a la url sin insertar los datos         
        $msg = "";
        $request = Request::createFromGlobals();
        $boton = $request->request->get('enviar');
        if (!$boton) {
            $msg = Estandar::msg_DebeDatos;
        } else {
            #para procesar los datos insertados
            $nombre = $request->request->get('name_nombre');
            $snombre = $request->request->get('name_snombre');
            $apellido = $request->request->get('name_apellido');
            $sapellido = $request->request->get('name_sapellido');
            $ci = $request->request->get('name_ci');
            $te = $request->request->get('name_telefono');
            $correo  = $request->request->get('name_correo');
            $cargo = $request->request->get('name_cargo');
            $idCliente = $request->request->get('name_clientes');

            $this->actualizar($id, $nombre, $snombre, $apellido, $sapellido, $ci, $te, $correo, $cargo, $idCliente);
            $msg = Estandar::msg_DatosActualizados;
        }
        #Despues de actualizar lo redirecciono al inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function listarAction() {
        $paginator = $this->get("ideup.simple_paginator");
        $listRepresentante = $paginator->paginate($this->listar())->getResult();
        $msg = "";
        return $this->render('PerfilacBundle:cliente:listarRepresentante.html.twig', array('representantes' => $listRepresentante, 'msg' => $msg));
    }

    #metodos para el trabajo con la base de datos

    private function salvar($nombre, $snombre, $apellido, $sapellido, $ci, $te, $correo, $cargo, $cliente) {
        $em = $this->getDoctrine()->getManager();

        $representante = new Representante();
        $representante->setPrimerNombre($nombre);
        $representante->setSegundoNombre($snombre);
        $representante->setPrimerApellido($apellido);
        $representante->setSegundoApellido($sapellido);
        $representante->setCi($ci);
        $representante->setTelefono($te);
        $representante->setCargo($cargo);
        $representante->setCorreo($correo);
        $representante->setCliente($cliente);


        $em->persist($representante);
        $em->flush();
    }

    private function actualizar($p_id, $p_nombre, $p_snombre, $p_apellido, $p_sapellido, $p_ci, $p_te, $correo, $p_cargo, $p_idCliente) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Representante');
        $representante = $repository->find($p_id);

        #actualizo los valores básicos
        $representante->setPrimerNombre($p_nombre);
        $representante->setSegundoNombre($p_snombre);
        $representante->setPrimerApellido($p_apellido);
        $representante->setSegundoApellido($p_sapellido);
        $representante->setCi($p_ci);
        $representante->setTelefono($p_te);
        $representante->setCorreo($correo);
        $representante->setCargo($p_cargo);

        $cliente = $this->obtenerCliente($p_idCliente);
        $representante->setCliente($cliente);
        
        $em->flush();
    }

    private function listar() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Representante');
        $representantes = $repository->findAll();

        return $representantes;
    }

    private function obtener($idRepresentante) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Representante');
        $representante = $repository->find($idRepresentante);
        return $representante;
    }

    private function listarClientes() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Cliente');
        $clientes = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $clientes;
    }

    private function obtenerCliente($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Cliente');
        $cliente = $repository->find($id);
        return $cliente;
    }

}
