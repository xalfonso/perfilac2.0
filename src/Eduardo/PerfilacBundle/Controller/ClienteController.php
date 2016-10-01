<?php

namespace Eduardo\PerfilacBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduardo\PerfilacBundle\Entity\Cliente;
use Eduardo\PerfilacBundle\Entity\Direccion;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Eduardo\PerfilacBundle\Util\Estandar;

/**
 * Controlador para el cliente
 * @author Eduardo Alfonso <eddie.alfonso@gmail.com>
 */
class ClienteController extends Controller {

    public function incluirAction($accion) {

        #cargo las provincias
        $provincias = $this->listarProvincias();

        #para comenzar a insertar 
        $msg = "";
        if ($accion == 'ini')
            return $this->render('PerfilacBundle:cliente:incluirCliente.html.twig', array('msg' => $msg, 'provincias' => $provincias));

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
                $codigo = $request->request->get('name_codigo');
                $contrato = $request->request->get('name_contrato');
                $cuentaCUC = $request->request->get('name_cuentaCUC');
                $cuentaCUP = $request->request->get('name_cuentaCUP');
                $nit = $request->request->get('name_nit');
                $suple = $request->request->get('name_suplemento');
                #tomar la direccion
                $provincia = $request->request->get('name_provincias');
                $municipio = $request->request->get('name_municipios');
                $ubicaDir = $request->request->get('name_text_dir');


                $this->salvar($nombre, $codigo, $contrato, $cuentaCUC, $cuentaCUP, $provincia, $municipio, $ubicaDir, $nit, $suple);
                $msg = Estandar::msg_DatosIncluidos;
            }

            return $this->render('PerfilacBundle:cliente:incluirCliente.html.twig', array('msg' => $msg, 'provincias' => $provincias));
            
        }

        #si no cumple con ninguno de los parametros lo redirecciono para el inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function modificarAction($id) {

        $msg = "";
        $cliente = $this->obtener($id);
        if ($cliente != NULL) {
            #cargo las provincias
            $provincias = $this->listarProvincias();
            return $this->render('PerfilacBundle:cliente:modificarCliente.html.twig', array('msg' => $msg, 'cliente' => $cliente, 'provincias' => $provincias));
        } else {
            #en caso que no exista un objeto con tal id redirecciono para el listar
            return new RedirectResponse($this->generateUrl('clienteListar'));
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
            $codigo = $request->request->get('name_codigo');
            $contrato = $request->request->get('name_contrato');
            $cuentaCUC = $request->request->get('name_cuentaCUC');
            $cuentaCUP = $request->request->get('name_cuentaCUP');
            $nit = $request->request->get('name_nit');
            $suple = $request->request->get('name_suplemento');
            #tomar la direccion
            $provincia = $request->request->get('name_provincias');
            $municipio = $request->request->get('name_municipios');
            $ubicaDir = $request->request->get('name_text_dir');

            $this->actualizar($id, $nombre, $codigo, $contrato, $cuentaCUC, $cuentaCUP, $provincia, $municipio, $ubicaDir, $nit, $suple);
            $msg = Estandar::msg_DatosActualizados;
        }

        #Despues de actualizar lo redirecciono al inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function listarAction() {
        $paginator = $this->get("ideup.simple_paginator");
        $listCliente = $paginator->paginate($this->listar())->getResult();
        $msg = "";
        return $this->render('PerfilacBundle:cliente:listarCliente.html.twig', array('clientes' => $listCliente, 'msg' => $msg));
    }

    public function listarMunicipioProvinciaAjaxAction($idProvincia) {
        $listMunicipio = $this->listarMunicipiosProvincias($idProvincia);
        $opts = "";
        for ($i = 0; $i < count($listMunicipio); $i++) {

            $idMunicipio = $listMunicipio[$i]->getId();
            $nombre = $listMunicipio[$i]->getNombre();
            $opts = $opts . "<option value='$idMunicipio'> $nombre </option>";
        }
        $response = new Response($opts);
        return $response;
    }

    #metodos para el trabajo con la base de datos

    private function salvar($nombre, $codigo, $contrato, $cuentaCUC, $cuentaCUP, $id_provincia, $id_municipio, $ubicaDir, $nit, $suple) {
        $em = $this->getDoctrine()->getManager();

        $cliente = new Cliente();
        $cliente->setNombre($nombre);
        $cliente->setCodigo($codigo);
        $cliente->setContrato($contrato);
        $cliente->setCuentaCUC($cuentaCUC);
        $cliente->setCuentaCUP($cuentaCUP);
        $cliente->setNit($nit);
        $cliente->setSuplemento($suple);


        #direccion 
        $direccion = new Direccion();
        if (isset($id_provincia)) {
            $provincia = $this->obtenerProvincia($id_provincia);
            $direccion->setProvincia($provincia);
        }
        if (isset($id_municipio)) {
            $municipio = $this->obtenerMunicipio($id_municipio);
            $direccion->setMunicipio($municipio);
        }

        $direccion->setDescripcion($ubicaDir);
        $cliente->setDireccion($direccion);

        $em->persist($cliente);
        $em->flush();
    }

    private function actualizar($p_id, $p_nombre, $p_codigo, $p_contrato, $p_cuentaCUC, $p_cuentaCUP, $p_idprovincia, $p_idmunicipio, $p_ubicaDir, $nit, $suple) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Cliente');
        $cliente = $repository->find($p_id);

        #actualizo los valores básicos
        $cliente->setNombre($p_nombre);
        $cliente->setCodigo($p_codigo);
        $cliente->setContrato($p_contrato);
        $cliente->setCuentaCUC($p_cuentaCUC);
        $cliente->setCuentaCUP($p_cuentaCUP);
        $cliente->setNit($nit);
        $cliente->setSuplemento($suple);

        #actualizo la direccion 
        if (isset($p_idprovincia)) {
            $provincia = $this->obtenerProvincia($p_idprovincia);
            $cliente->getDireccion()->setProvincia($provincia);
        }
        if (isset($p_idmunicipio)) {
            $municipio = $this->obtenerMunicipio($p_idmunicipio);
            $cliente->getDireccion()->setMunicipio($municipio);
        }

        $cliente->getDireccion()->setDescripcion($p_ubicaDir);

        $em->flush();
    }

    private function listar() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Cliente');
        $clientes = $repository->findAll();

        return $clientes;
    }

    private function obtener($idCliente) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Cliente');
        $cliente = $repository->find($idCliente);
        return $cliente;
    }

    private function listarProvincias() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Provincia');
        $provincias = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $provincias;
    }

    private function listarMunicipiosProvincias($idProvincia) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Municipio');
        $municipios = $repository->findBy(array('provincia' => $idProvincia), array('nombre' => 'ASC'));
        return $municipios;
    }

    private function obtenerMunicipio($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Municipio');
        $municipio = $repository->find($id);
        return $municipio;
    }

    private function obtenerProvincia($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Provincia');
        $provincia = $repository->find($id);
        return $provincia;
    }

}
