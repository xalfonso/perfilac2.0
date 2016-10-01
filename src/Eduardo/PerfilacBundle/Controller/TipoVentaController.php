<?php

namespace Eduardo\PerfilacBundle\Controller;

use Eduardo\PerfilacBundle\Entity\TipoVenta;
use Eduardo\PerfilacBundle\Util\Estandar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TipoVentaController extends Controller {

    public function incluirAction($accion) {
        #para comenzar a insertar 
        $msg = "";
        if ($accion == 'ini')
            return $this->render('PerfilacBundle:nomencladores:incluirTipoVenta.html.twig', array('msg' => $msg));

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

            return $this->render('PerfilacBundle:nomencladores:incluirTipoVenta.html.twig', array('msg' => $msg));
        }

        #si no cumple con ninguno de los parametros lo redirecciono para el inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function listarAction() {
        $paginator = $this->get("ideup.simple_paginator");
        $listTipoVentas = $paginator->paginate($this->listar())->getResult();

        $msg = "";
        return $this->render('PerfilacBundle:nomencladores:listarTipoVenta.html.twig', array('tiposVenta' => $listTipoVentas, 'msg' => $msg));
    }
    
    public function modificarAction($id) {
        
        $msg = "";
        $tipoVenta = $this->obtener($id);  
        if($tipoVenta != NULL)
          return $this->render('PerfilacBundle:nomencladores:modificarTipoVenta.html.twig', array('tipoVenta' => $tipoVenta, 'msg' => $msg));
        else
        {
          #en caso que no exista un objeto con tal id redirecciono para el listar
          return  new RedirectResponse($this->generateUrl('tipoVentaListar')); 
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
          return  new RedirectResponse($this->generateUrl('tipoVentaListar')); 
    }

    #metodos para el trabajo con la base de datos

    private function salvar($p_nombre) {
        $em = $this->getDoctrine()->getManager();
        $tipoVenta = new TipoVenta($p_nombre);        
        $em->persist($tipoVenta);
        $em->flush();
    }

    private function listar() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:TipoVenta');
        $tiposVentas = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $tiposVentas;
    }
    
    private function obtener($id) {
            $repository = $this->getDoctrine()->getRepository('PerfilacBundle:TipoVenta');
            $tipoVenta = $repository->find($id);
            return $tipoVenta;
        }
        
    private function actualizar($p_id,$p_nombre) {
            $em = $this->getDoctrine()->getManager();    
            $repository = $this->getDoctrine()->getRepository('PerfilacBundle:TipoVenta');
            $tipoVenta = $repository->find($p_id);
            $tipoVenta->setNombre($p_nombre);
            $em->flush();
        }

}
