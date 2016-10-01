<?php

namespace Eduardo\PerfilacBundle\Controller;

use Eduardo\PerfilacBundle\Entity\Provincia;
use Eduardo\PerfilacBundle\Util\Estandar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Eduardo Alfonso Sanchez <eddie.alfonso@gmail.com>
 */
class ProvinciaController extends Controller {

    public function incluirAction($accion) {
        #para comenzar a insertar 
        $msg = "";
        if ($accion == 'ini')
            return $this->render('PerfilacBundle:direccion:incluirProvincia.html.twig', array('msg' => $msg));

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
                $this->salvar($p_nombre);
                $msg = Estandar::msg_DatosIncluidos;
            }

            return $this->render('PerfilacBundle:direccion:incluirProvincia.html.twig', array('msg' => $msg));
        }

        #si no cumple con ninguno de los parametros lo redirecciono para el inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function listarAction() {
        $paginator = $this->get("ideup.simple_paginator");
        $listProvincias = $paginator->paginate($this->listar())->getResult();

        $msg = "";
        return $this->render('PerfilacBundle:direccion:listarProvincia.html.twig', array('provincias' => $listProvincias, 'msg' => $msg));
    }
    
    public function modificarAction($id) {
        
        $msg = "";
        $provincia = $this->obtener($id);  
        if($provincia != NULL)
          return $this->render('PerfilacBundle:direccion:modificarProvincia.html.twig', array('provincia' => $provincia, 'msg' => $msg));
        else
        {
          #en caso que no exista un objeto con tal id redirecciono para el listar
          return  new RedirectResponse($this->generateUrl('provinciaListar')); 
        }
    }
    
    public function actualizarAction($id) {
        
          #verificar que no acceda a la url sin insertar los datos         
          $msg = "";
          $request = Request::createFromGlobals();
          $boton =  $request->request->get('enviar');
          if(!$boton)
          {
            $msg = Estandar::msg_DebeDatos;
          }
          else
          {
           #para procesar los datos insertados
           $p_nombre = $request->request->get('inp_nombre');
           $this->actualizar($id, $p_nombre);
           $msg = Estandar::msg_DatosActualizados;
          }
          
          #Despues de actualizar lo redirecciono al listar
          return  new RedirectResponse($this->generateUrl('provinciaListar')); 
    }

    #metodos para el trabajo con la base de datos

    private function salvar($p_nombre) {
        $em = $this->getDoctrine()->getManager();
        $provincia = new Provincia();
        $provincia->setNombre($p_nombre);
        $em->persist($provincia);
        $em->flush();
    }

    private function listar() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Provincia');
        $provincias = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $provincias;
    }
    
    private function obtener($id) {
            $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Provincia');
            $provincia = $repository->find($id);
            return $provincia;
        }
        
    private function actualizar($p_id,$p_nombre) {
            $em = $this->getDoctrine()->getManager();    
            $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Provincia');
            $provincia = $repository->find($p_id);
            $provincia->setNombre($p_nombre);
            $em->flush();
        }

}
