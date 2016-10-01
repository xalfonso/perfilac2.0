<?php

namespace Eduardo\PerfilacBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduardo\PerfilacBundle\Entity\Cliente;
use Eduardo\PerfilacBundle\Entity\Producto;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Eduardo\PerfilacBundle\Util\Estandar;

/**
 * Controlador para el producto
 * @author Eduardo Alfonso <eddie.alfonso@gmail.com>
 */
class ProductoController extends Controller {

    public function incluirAction($accion) {

        #cargo los tipos de productos
        $tipos = $this->listarTipos();

        #cargo los tipos de enchapes
        $tiposenchape = $this->listarTiposEnchape();

        #cargo los suministradores
        $suministradores = $this->listarSuministradores();

        #para comenzar a insertar 
        $msg = "";
        if ($accion == 'ini')
            return $this->render('PerfilacBundle:producto:incluirProducto.html.twig', array('msg' => $msg, 'tipos' => $tipos, 'tipose' => $tiposenchape, 'suministradores' => $suministradores));

        #para procesar los datos insertados
        if ($accion == 'ej') {
            #verificar que no acceda a la url sin insertar los datos         
            $request = Request::createFromGlobals();
            $boton = $request->request->get('enviar');
            if (!$boton) {
                $msg = Estandar::msg_DebeDatos;
            } else {
                #para procesar los datos insertados
                $codigo = $request->request->get('name_codigo');
                $nficha = $request->request->get('name_nficha');
                $precioCUP = $request->request->get('name_cup');
                $precioCUC = $request->request->get('name_cuc');
                $color = $request->request->get('name_color');
                $descripcion = $request->request->get('name_des');

                $idTipo = $request->request->get('name_tipos');
                $tipo = $this->obtenerTipo($idTipo);

                $idTipoEnchape = $request->request->get('name_tiposen');
                $tipoEnchape = $this->obtenerTipoEnchape($idTipoEnchape);

                $idSuministrador = $request->request->get('name_suministrador');
                $suministrador = $this->obtenerSuministrador($idSuministrador);



                $this->salvar($codigo, $nficha, $precioCUP, $precioCUC, $color, $descripcion, $tipo, $tipoEnchape, $suministrador);
                $msg = Estandar::msg_DatosIncluidos;
            }

            return $this->render('PerfilacBundle:producto:incluirProducto.html.twig', array('msg' => $msg, 'tipos' => $tipos, 'tipose' => $tiposenchape, 'suministradores' => $suministradores));
        }

        #si no cumple con ninguno de los parametros lo redirecciono para el inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function modificarAction($id) {

        $msg = "";
        $producto = $this->obtener($id);
        if ($producto != NULL) {

            #cargo los tipos de productos
            $tipos = $this->listarTipos();

            #cargo los tipos de enchapes
            $tiposenchape = $this->listarTiposEnchape();

            #cargo los suministradores
            $suministradores = $this->listarSuministradores();

            return $this->render('PerfilacBundle:producto:modificarProducto.html.twig', array('msg' => $msg, 'producto' => $producto, 'tipos' => $tipos, 'tipose' => $tiposenchape, 'suministradores' => $suministradores));
        } else {
            #en caso que no exista un objeto con tal id redirecciono para el listar
            return new RedirectResponse($this->generateUrl('productoListar'));
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
            $codigo = $request->request->get('name_codigo');
            $nficha = $request->request->get('name_nficha');
            $precioCUP = $request->request->get('name_cup');
            $precioCUC = $request->request->get('name_cuc');
            $color = $request->request->get('name_color');
            $descripcion = $request->request->get('name_des');

            $idTipo = $request->request->get('name_tipos');
            $idTipoEnchape = $request->request->get('name_tiposen');
            $idSuministrador = $request->request->get('name_suministrador');
            
            $this->actualizar($id, $codigo, $nficha, $precioCUP, $precioCUC, $color, $descripcion, $idTipo, $idTipoEnchape, $idSuministrador);
            $msg = Estandar::msg_DatosActualizados;
        }
        #Despues de actualizar lo redirecciono al inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function listarAction() {
        $paginator = $this->get("ideup.simple_paginator");
        $listProducto = $paginator->paginate($this->listar())->getResult();
        $msg = "";
        return $this->render('PerfilacBundle:producto:listarProducto.html.twig', array('productos' => $listProducto, 'msg' => $msg));
    }

    #metodos para el trabajo con la base de datos

    private function salvar($codigo, $nficha, $precioCUP, $precioCUC, $color, $descripcion, $tipo, $tipoEnchape, $suministrador) {
        $em = $this->getDoctrine()->getManager();

        $producto = new Producto();
        $producto->setCodigo($codigo);
        $producto->setNoFicha($nficha);
        $producto->setPrecioCUP($precioCUP);
        $producto->setPrecioCUC($precioCUC);
        $producto->setColor($color);
        $producto->setDescripcion($descripcion);
        $producto->setTipoProducto($tipo);
        $producto->setTipoEnchape($tipoEnchape);
        $producto->setSuministrador($suministrador);

        $em->persist($producto);
        $em->flush();
    }

    private function actualizar($p_id, $codigo, $nficha, $precioCUP, $precioCUC, $color, $descripcion, $idTipo, $idTipoEnchape, $idSuministrador) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Producto');
        $producto = $repository->find($p_id);

        #actualizo los valores básicos
        $producto->setCodigo($codigo);
        $producto->setNoFicha($nficha);
        $producto->setPrecioCUP($precioCUP);
        $producto->setPrecioCUC($precioCUC);
        $producto->setColor($color);
        $producto->setDescripcion($descripcion);

        $tipo = $this->obtenerTipo($idTipo);
        $tipoEnchape = $this->obtenerTipoEnchape($idTipoEnchape);
        $suministrador = $this->obtenerSuministrador($idSuministrador);

        $producto->setTipoProducto($tipo);
        $producto->setTipoEnchape($tipoEnchape);
        $producto->setSuministrador($suministrador);        

        $em->flush();
    }

    private function listar() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Producto');
        $productos = $repository->findAll();

        return $productos;
    }

    private function obtener($idProducto) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Producto');
        $producto = $repository->find($idProducto);
        return $producto;
    }

    private function listarTipos() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:TipoProducto');
        $tipos = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $tipos;
    }

    private function listarTiposEnchape() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:TipoEnchape');
        $tipose = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $tipose;
    }

    private function listarSuministradores() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Suministrador');
        $suministradores = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $suministradores;
    }    

    private function obtenerTipo($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:TipoProducto');
        $tipo = $repository->find($id);
        return $tipo;
    }

    private function obtenerTipoEnchape($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:TipoEnchape');
        $tipoEnchape = $repository->find($id);
        return $tipoEnchape;
    }

    private function obtenerSuministrador($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Suministrador');
        $suministrador = $repository->find($id);
        return $suministrador;
    }

}
