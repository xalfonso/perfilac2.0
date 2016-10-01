<?php

namespace Eduardo\PerfilacBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduardo\PerfilacBundle\Entity\Cliente;
use Eduardo\PerfilacBundle\Entity\Venta;
use Eduardo\PerfilacBundle\Entity\Representante;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Eduardo\PerfilacBundle\Util\Estandar;
use Eduardo\PerfilacBundle\Entity\ProductoVenta;

/**
 * Controlador para la Venta
 * @author Eduardo Alfonso <eddie.alfonso@gmail.com>
 */
class VentaController extends Controller {

    public function incluirAction($accion) {

        #cargo los clientes
        $clientes = $this->listarClientes();

        #cargo los tipos de venta
        $tipos = $this->listarTipos();

        #cargo los productos
        $productos = $this->listarProductos();

        #cargo los tipos de productos
        $tipoProductos = $this->listarTipoProductos();

        #cargo los tipos de enchape
        $tipoEnchapes = $this->listarTipoEnchapes();

        #para comenzar a insertar 
        $msg = "";
        if ($accion == 'ini')
            return $this->render('PerfilacBundle:venta:incluirVenta.html.twig', array('msg' => $msg, 'clientes' => $clientes, 'tipos' => $tipos, 'productos' => $productos, 'tipoproductos' => $tipoProductos, 'tipoenchapes' => $tipoEnchapes));

        #para procesar los datos insertados
        if ($accion == 'ej') {
            #verificar que no acceda a la url sin insertar los datos         
            $request = Request::createFromGlobals();
            $boton = $request->request->get('enviar');
            if (!$boton) {
                $msg = Estandar::msg_DebeDatos;
            } else {
                #para procesar los datos insertados
                $numero = $request->request->get('name_numero');
                $obra = $request->request->get('name_obra');

                $idTipoVenta = $request->request->get('name_tipo');
                $tipoVenta = $this->obtenerTipoVenta($idTipoVenta);

                $fecha = $request->request->get('name_fecha');
                #obtengo la fecha separada y la convieto a Date de PHP
                $arregloFecha = explode("/", $fecha);
                $month = $arregloFecha[0];
                $day = $arregloFecha[1];
                $year = $arregloFecha[2];
                $fechaDate = new \DateTime();
                $fechaDate->setDate($year, $month, $day);

                $idCliente = $request->request->get('name_clientes');
                $cliente = $this->obtenerCliente($idCliente);

                $idRepresentante = $request->request->get('name_representantes');
                $representante = $this->obtenerRepresentante($idRepresentante);


                //obtener los productos de la venta, los id y lo otros datos del productoVenta
                $idP = $request->request->get('idProductos');
                $anchosP = $request->request->get('anchosProductos');
                $altosP = $request->request->get('altosProductos');
                $cantP = $request->request->get('cantProductos');


                $listProductosVenta = array();
                for ($i = 0; $i < count($idP); $i++) {
                    $productoVenta = new ProductoVenta();
                    $producto = $this->obtenerProducto($idP[$i]);
                    $productoVenta->setProducto($producto);

                    $productoVenta->setAlto($altosP[$i]);
                    $productoVenta->setAncho($anchosP[$i]);
                    $productoVenta->setCant($cantP[$i]);
                    $listProductosVenta[$i] = $productoVenta;
                }

                #Obtener el comercial
                $usuarioLogueado = $this->getUser();
                $comercial = $this->obtenerComercialPorUsuario($usuarioLogueado);


                #datos del transportador
                $nombreTransportador = $request->request->get('name_nombTransportador');
                $ciTransportador = $request->request->get('name_ciTransportador');
                $chapaTransportador = $request->request->get('name_chapaTransportador');
                $licenciaTransportador = $request->request->get('name_licenciaTransportador');
                $cargoTransportador = $request->request->get('name_cargoTransportador');


                $this->salvar($numero, $tipoVenta, $fechaDate, $cliente, $representante, $listProductosVenta, $obra, $comercial, $nombreTransportador, $ciTransportador, $chapaTransportador, $licenciaTransportador, $cargoTransportador);
                $msg = Estandar::msg_DatosIncluidos;
            }

            return $this->render('PerfilacBundle:venta:incluirVenta.html.twig', array('msg' => $msg, 'clientes' => $clientes, 'tipos' => $tipos, 'productos' => $productos, 'tipoproductos' => $tipoProductos));
        }

        #si no cumple con ninguno de los parametros lo redirecciono para el inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function modificarAction($id) {

        $msg = "";
        $venta = $this->obtener($id);
        if ($venta != NULL) {
            #cargo los clientes
            $clientes = $this->listarClientes();

            #cargo los tipos de venta
            $tipos = $this->listarTipos();

            #cargo los productos
            $productos = $this->listarProductos();

            #cargar los productos venta
            $productosVenta = $this->ProductosVentaPorVenta($venta->getId());

            return $this->render('PerfilacBundle:venta:modificarVenta.html.twig', array('msg' => $msg, 'venta' => $venta, 'tipos' => $tipos, 'clientes' => $clientes, 'productos' => $productos, 'productosVenta' => $productosVenta));
        } else {
            #en caso que no exista un objeto con tal id redirecciono para el listar
            return new RedirectResponse($this->generateUrl('ventaListar'));
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
            $numero = $request->request->get('name_numero');
            $obra = $request->request->get('name_obra');

            $idTipoVenta = $request->request->get('name_tipo');
            $tipoVenta = $this->obtenerTipoVenta($idTipoVenta);

            $fecha = $request->request->get('name_fecha');
            #obtengo la fecha separada y la convieto a Date de PHP
            $arregloFecha = explode("/", $fecha);
            $month = $arregloFecha[0];
            $day = $arregloFecha[1];
            $year = $arregloFecha[2];
            $fechaDate = new \DateTime();
            $fechaDate->setDate($year, $month, $day);

            $idCliente = $request->request->get('name_clientes');
            $cliente = $this->obtenerCliente($idCliente);

            $idRepresentante = $request->request->get('name_representantes');
            $representante = $this->obtenerRepresentante($idRepresentante);


            //obtener los productos de la venta, los id y lo otros datos del productoVenta
            $idP = $request->request->get('idProductos');
            $anchosP = $request->request->get('anchosProductos');
            $altosP = $request->request->get('altosProductos');
            $cantP = $request->request->get('cantProductos');


            $listProductosVenta = array();
            for ($i = 0; $i < count($idP); $i++) {
                $productoVenta = new ProductoVenta();
                $producto = $this->obtenerProducto($idP[$i]);
                $productoVenta->setProducto($producto);

                $productoVenta->setAlto($altosP[$i]);
                $productoVenta->setAncho($anchosP[$i]);
                $productoVenta->setCant($cantP[$i]);
                $listProductosVenta[$i] = $productoVenta;
            }

            #datos del transportador
            $nombreTransportador = $request->request->get('name_nombTransportador');
            $ciTransportador = $request->request->get('name_ciTransportador');
            $chapaTransportador = $request->request->get('name_chapaTransportador');
            $licenciaTransportador = $request->request->get('name_licenciaTransportador');
            $cargoTransportador = $request->request->get('name_cargoTransportador');

            $this->actualizar($id, $numero, $tipoVenta, $fechaDate, $cliente, $representante, $listProductosVenta, $obra, $nombreTransportador, $ciTransportador, $chapaTransportador, $licenciaTransportador, $cargoTransportador);
            $msg = Estandar::msg_DatosActualizados;
        }
        #Despues de actualizar lo redirecciono al inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function listarAction() {
        $paginator = $this->get("ideup.simple_paginator");
        $listVentas = $paginator->paginate($this->listar())->getResult();
        $msg = "";
        return $this->render('PerfilacBundle:venta:listarVenta.html.twig', array('ventas' => $listVentas, 'msg' => $msg));
    }

    public function verAction($id) {
        $msg = "";
        $venta = $this->obtener($id);
        return $this->render('PerfilacBundle:venta:verVenta.html.twig', array('venta' => $venta, 'msg' => $msg));
    }

    public function eliminarAction($id) {
        $msg = "";
        $venta = $this->obtener($id);
        if ($venta != NULL) {
            $this->eliminar($venta);
        }
        return new RedirectResponse($this->generateUrl('ventaListar'));
    }

    public function listarRepresentanteClienteAjaxAction($idCliente) {
        $listRepresentante = $this->listarRepresentanteCliente($idCliente);
        $opts = "";
        for ($i = 0; $i < count($listRepresentante); $i++) {

            $idRepresentante = $listRepresentante[$i]->getId();
            $nombre = $listRepresentante[$i]->getNombreCompleto();
            $opts = $opts . "<option value='$idRepresentante'> $nombre </option>";
        }
        $response = new Response($opts);
        return $response;
    }

    public function listarDetalleProductoAjaxAction($idProducto) {
        /* En este metodo utilice una forma no convencional de mandar información hacie el cliente, una estructura de datos separada por el simbolo <>
          lo correcto hibierta sido utilizar json o xml */

        $producto = $this->obtenerProducto($idProducto);
        $opts = "";
        $opts = $producto->getId() . "<>" . $producto->getCodigo() . "<>" . $producto->getNoFicha() . "<>" . $producto->getPrecioCUP() . "<>" . $producto->getPrecioCUC() . "<>" . $producto->getColor() . "<>" . $producto->getDescripcion();

        $response = new Response($opts);
        return $response;
    }

    public function listarProductosAjaxAction($idTipoProducto, $idTipoEnchape) {
        /* En este metodo utilice una forma no convencional de mandar información hacie el cliente, una estructura de datos separada por el simbolo <>
          lo correcto hibierta sido utilizar json o xml */

        $productos = $this->listarProductosPorTipos($idTipoProducto, $idTipoEnchape);
                
        #aqui tengo que hacer un array de array porque cada producto es un array y son varios
        $productosArrayJson = array();
        foreach ($productos as $producto) {
            $productosArrayJson[] = array('id' => $producto->getId(),'codigo'=>$producto->getCodigo());
        }
        
        $response = new Response(json_encode($productosArrayJson));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    #metodos para el trabajo con la base de datos

    private function salvar($numero, $tipoVenta, $fechaDate, $cliente, $representante, $listProductosVenta, $obra, $comercial, $nombreTransportador, $ciTransportador, $chapaTransportador, $licenciaTransportador, $cargoTransportador) {
        $em = $this->getDoctrine()->getManager();

        $venta = new Venta();
        $venta->setNumero($numero);
        $venta->setTipoVenta($tipoVenta);
        $venta->setFecha($fechaDate);
        $venta->setCliente($cliente);
        $venta->setRepresentante($representante);
        $venta->setObra($obra);
        $venta->setComercial($comercial);
        $venta->setVendedor($comercial->getVendedor());

        #datos del transportador
        $venta->setNombreTransportador($nombreTransportador);
        $venta->setCiTransportador($ciTransportador);
        $venta->setChapaTransportador($chapaTransportador);
        $venta->setLicenciaTransportador($licenciaTransportador);
        $venta->setCargoTransportador($cargoTransportador);

        for ($i = 0; $i < count($listProductosVenta); $i++) {
            $listProductosVenta[$i]->setVenta($venta);
            $venta->addProductosVenta($listProductosVenta[$i]);
        }

        $em->persist($venta);
        $em->flush();
    }

    private function listarRepresentanteCliente($idCliente) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Representante');
        $representantes = $repository->findBy(array('cliente' => $idCliente), array('primerNombre' => 'ASC'));
        return $representantes;
    }

    private function ProductosVentaPorVenta($idVenta) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:ProductoVenta');
        $productosVenta = $repository->findBy(array('venta' => $idVenta), array('id' => 'ASC'));
        return $productosVenta;
    }

    private function obtenerComercialPorUsuario($usuarioLogueado) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Comercial');
        $comercial = $repository->findOneBy(array('usuario' => $usuarioLogueado->getId()), array('primerNombre' => 'ASC'));
        return $comercial;
    }

    private function actualizar($p_id, $numero, $tipoVenta, $fechaDate, $cliente, $representante, $listProductosVenta, $obra, $nombreTransportador, $ciTransportador, $chapaTransportador, $licenciaTransportador, $cargoTransportador) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Venta');
        $venta = $repository->find($p_id);

        #actualizo los valores básicos
        $venta->setNumero($numero);
        $venta->setTipoVenta($tipoVenta);
        $venta->setFecha($fechaDate);
        $venta->setCliente($cliente);
        $venta->setRepresentante($representante);
        $venta->setObra($obra);

        #datos del transportador
        $venta->setNombreTransportador($nombreTransportador);
        $venta->setCiTransportador($ciTransportador);
        $venta->setChapaTransportador($chapaTransportador);
        $venta->setLicenciaTransportador($licenciaTransportador);
        $venta->setCargoTransportador($cargoTransportador);

        for ($i = 0; $i < count($listProductosVenta); $i++) {
            $listProductosVenta[$i]->setVenta($venta);
            $venta->addProductosVenta($listProductosVenta[$i]);
        }

        $em->flush();
    }

    private function listar() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Venta');
        $ventas = $repository->findAll();

        return $ventas;
    }

    private function obtener($idVenta) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Venta');
        $venta = $repository->find($idVenta);
        return $venta;
    }

    private function eliminar($venta) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($venta);
        $em->flush();
    }

    private function listarClientes() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Cliente');
        $clientes = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $clientes;
    }

    private function listarTipos() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:TipoVenta');
        $tiposVentas = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $tiposVentas;
    }

    private function listarTipoProductos() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:TipoProducto');
        $tiposProducto = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $tiposProducto;
    }

    private function listarTipoEnchapes() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:TipoEnchape');
        $tiposEnchape = $repository->findBy(array(), array('nombre' => 'ASC'));
        return $tiposEnchape;
    }

    private function listarProductos() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Producto');
        $productos = $repository->findBy(array(), array('codigo' => 'ASC'));
        return $productos;
    }

    private function listarProductosPorTipos($idTipoProducto, $idTipoEnchape) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Producto');
        $productos = $repository->findBy(array('tipoProducto' => $idTipoProducto, 'tipoEnchape' => $idTipoEnchape), array('codigo' => 'ASC'));
        return $productos;
    }

    private function obtenerCliente($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Cliente');
        $cliente = $repository->find($id);
        return $cliente;
    }

    private function obtenerRepresentante($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Representante');
        $representante = $repository->find($id);
        return $representante;
    }

    private function obtenerProducto($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Producto');
        $producto = $repository->find($id);
        return $producto;
    }

    private function obtenerTipoVenta($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:TipoVenta');
        $tipo = $repository->find($id);
        return $tipo;
    }

}
