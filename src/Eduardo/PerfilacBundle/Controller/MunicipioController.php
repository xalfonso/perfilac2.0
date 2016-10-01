<?php

namespace Eduardo\PerfilacBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduardo\PerfilacBundle\Entity\Provincia;
use Eduardo\PerfilacBundle\Entity\Municipio;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Eduardo\PerfilacBundle\Util\Estandar;

/**
 * Controlador para el municipio
 * @author Eduardo Alfonso Sanchez <eddie.alfonso@gmail.com>
 */
class MunicipioController extends Controller {

    public function incluirAction($accion) {

        #cargo las provincias
        $provincias = $this->listarProvincias();

        #para comenzar a insertar 
        $msg = "";
        if ($accion == 'ini')
            return $this->render('PerfilacBundle:direccion:incluirMunicipio.html.twig', array('msg' => $msg, 'provincias' => $provincias));

        #para procesar los datos insertados
        if ($accion == 'ej') {
            #verificar que no acceda a la url sin insertar los datos         
            $request = Request::createFromGlobals();
            $boton = $request->request->get('enviar');
            if (!$boton) {
                $msg = Estandar::msg_DebeDatos;
            } else {
                #para procesar los datos insertados
                $p_nombre = $request->request->get('inp_nombre');
                $idProvincia = $request->request->get('name_provincias');
                $provincia = $this->obtenerProvincia($idProvincia);
                $this->salvar($p_nombre, $provincia);
                $msg = Estandar::msg_DatosIncluidos;
            }

            return $this->render('PerfilacBundle:direccion:incluirMunicipio.html.twig', array('msg' => $msg, 'provincias' => $provincias));
        }

        #si no cumple con ninguno de los parametros lo redirecciono para el inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function modificarAction($id) {

        #cargo las provincias
        $provincias = $this->listarProvincias();

        $msg = "";
        $municipio = $this->obtener($id);
        if ($municipio != NULL)
            return $this->render('PerfilacBundle:direccion:modificarMunicipio.html.twig', array('provincias' => $provincias, 'municipio' => $municipio, 'msg' => $msg));
        else {
            #en caso que no exista un objeto con tal id redirecciono para el listar
            return new RedirectResponse($this->generateUrl('municipioListar'));
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
            $p_nombre = $request->request->get('inp_nombre');
            $idProvincia = $request->request->get('name_provincias');
            $provincia = $this->obtenerProvincia($idProvincia);
            $this->actualizar($id, $p_nombre, $provincia);
            $msg = Estandar::msg_DatosActualizados;
        }

        #Despues de actualizar lo redirecciono al listar
        return new RedirectResponse($this->generateUrl('municipioListar'));
    }

    public function listarAction() {

        $paginator = $this->get("ideup.simple_paginator");
        $listMunicipios = $paginator->paginate($this->listar())->getResult();

        $msg = "";
        return $this->render('PerfilacBundle:direccion:listarMunicipio.html.twig', array('municipios' => $listMunicipios, 'msg' => $msg));
    }

    #metodos para el trabajo con la base de datos

    private function salvar($p_nombre, $provincia) {
        $em = $this->getDoctrine()->getManager();
        $municipio = new Municipio($p_nombre);
        $municipio->setProvincia($provincia);
        $em->persist($municipio);
        $em->flush();
    }

    private function actualizar($p_id, $p_nombre, $provincia) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Municipio');
        $municipio = $repository->find($p_id);
        $municipio->setNombre($p_nombre);
        $municipio->setProvincia($provincia);
        $em->flush();
    }

    private function listar() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Municipio');
        $municipios = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $municipios;
    }

    private function obtener($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Municipio');
        $municipio = $repository->find($id);
        return $municipio;
    }

    private function listarProvincias() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Provincia');
        $provincias = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $provincias;
    }

    private function obtenerProvincia($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Provincia');
        $provincia = $repository->find($id);
        return $provincia;
    }

}
