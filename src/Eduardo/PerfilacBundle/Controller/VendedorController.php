<?php

namespace Eduardo\PerfilacBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduardo\PerfilacBundle\Entity\Vendedor;
use Eduardo\PerfilacBundle\Entity\Direccion;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Eduardo\PerfilacBundle\Util\Estandar;

/**
 * Controlador para el vendedor
 * @author Eduardo Alfonso <eddie.alfonso@gmail.com>
 */
class VendedorController extends Controller {

    public function incluirAction($accion) {

        #cargo las provincias
        $provincias = $this->listarProvincias();

        #para comenzar a insertar 
        $msg = "";
        if ($accion == 'ini')
            return $this->render('PerfilacBundle:vendedor:incluirVendedor.html.twig', array('msg' => $msg, 'provincias' => $provincias));

        #para procesar los datos insertados
        if ($accion == 'ej') {
            #verificar que no acceda a la url sin insertar los datos         
            $request = Request::createFromGlobals();
            $boton = $request->request->get('enviar');
            if (!$boton) {
                $msg = Estandar::msg_DebeDatos;
            } else {
                #para procesar los datos insertados
                $grupoEmpresarial = $request->request->get('name_grupoEmpresarial');
                $empresa = $request->request->get('name_empresa');
                $taller = $request->request->get('name_taller');
                $nit = $request->request->get('name_nit');
                $codigo = $request->request->get('name_codigo');
                $comentarioFactura = $request->request->get('name_comentarioFactura');
                $cuentaCUC = $request->request->get('name_cuentaCUC');
                $nombreCuentaCUC = $request->request->get('name_nombreCuentaCUC');
                $cuentaCUP = $request->request->get('name_cuentaCUP');
                $nombreCuentaCUP = $request->request->get('name_nombreCuentaCUP');
                $sucursal = $request->request->get('name_sucursal');

                #tomar la direccion
                $provincia = $request->request->get('name_provincias');
                $municipio = $request->request->get('name_municipios');
                $ubicaDir = $request->request->get('name_text_dir');


                $this->salvar($grupoEmpresarial, $empresa, $taller, $nit, $codigo, $comentarioFactura, $cuentaCUC, $nombreCuentaCUC, $cuentaCUP, $nombreCuentaCUP, $sucursal, $provincia, $municipio, $ubicaDir);
                $msg = Estandar::msg_DatosIncluidos;
            }

            return $this->render('PerfilacBundle:vendedor:incluirVendedor.html.twig', array('msg' => $msg, 'provincias' => $provincias));
        }

        #si no cumple con ninguno de los parametros lo redirecciono para el inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function modificarAction($id) {

        $msg = "";
        $vendedor = $this->obtener($id);
        if ($vendedor != NULL) {
            #cargo las provincias
            $provincias = $this->listarProvincias();
            return $this->render('PerfilacBundle:vendedor:modificarVendedor.html.twig', array('msg' => $msg, 'vendedor' => $vendedor, 'provincias' => $provincias));
        } else {
            #en caso que no exista un objeto con tal id redirecciono para el listar
            return new RedirectResponse($this->generateUrl('vendedorListar'));
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
            $grupoEmpresarial = $request->request->get('name_grupoEmpresarial');
            $empresa = $request->request->get('name_empresa');
            $taller = $request->request->get('name_taller');
            $nit = $request->request->get('name_nit');
            $codigo = $request->request->get('name_codigo');
            $comentarioFactura = $request->request->get('name_comentarioFactura');
            $cuentaCUC = $request->request->get('name_cuentaCUC');
            $nombreCuentaCUC = $request->request->get('name_nombreCuentaCUC');
            $cuentaCUP = $request->request->get('name_cuentaCUP');
            $nombreCuentaCUP = $request->request->get('name_nombreCuentaCUP');
            $sucursal = $request->request->get('name_sucursal');

            #tomar la direccion
            $provincia = $request->request->get('name_provincias');
            $municipio = $request->request->get('name_municipios');
            $ubicaDir = $request->request->get('name_text_dir');

            $this->actualizar($id, $grupoEmpresarial, $empresa, $taller, $nit, $codigo, $comentarioFactura, $cuentaCUC, $nombreCuentaCUC, $cuentaCUP, $nombreCuentaCUP, $sucursal, $provincia, $municipio, $ubicaDir);
            $msg = Estandar::msg_DatosActualizados;
        }

        #Despues de actualizar lo redirecciono al inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function listarAction() {
        $paginator = $this->get("ideup.simple_paginator");
        $listVendedor = $paginator->paginate($this->listar())->getResult();
        $msg = "";
        return $this->render('PerfilacBundle:vendedor:listarVendedor.html.twig', array('vendedores' => $listVendedor, 'msg' => $msg));
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

    private function salvar($grupoEmpresarial, $empresa, $taller, $nit, $codigo, $comentarioFactura, $cuentaCUC, $nombreCuentaCUC, $cuentaCUP, $nombreCuentaCUP, $sucursal, $id_provincia, $id_municipio, $ubicaDir) {
        $em = $this->getDoctrine()->getManager();

        $vendedor = new Vendedor();
        $vendedor->setGrupoEmpresarial($grupoEmpresarial);
        $vendedor->setEmpresa($empresa);
        $vendedor->setTaller($taller);
        $vendedor->setNit($nit);
        $vendedor->setCodigo($codigo);
        $vendedor->setComentarioFactura($comentarioFactura);
        $vendedor->setCuentaCUC($cuentaCUC);
        $vendedor->setNombrecuentaCUC($nombreCuentaCUC);
        $vendedor->setCuentaCUP($cuentaCUP);
        $vendedor->setNombrecuentaCUP($nombreCuentaCUP);
        $vendedor->setSucursal($sucursal);
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
        $vendedor->setDireccionEmpresa($direccion);

        $em->persist($vendedor);
        $em->flush();
    }

    private function actualizar($p_id, $grupoEmpresarial, $empresa, $taller, $nit, $codigo, $comentarioFactura, $cuentaCUC, $nombreCuentaCUC, $cuentaCUP, $nombreCuentaCUP, $sucursal, $id_provincia, $id_municipio, $ubicaDir) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Vendedor');
        $vendedor = $repository->find($p_id);

        #actualizo los valores básicos
        $vendedor->setGrupoEmpresarial($grupoEmpresarial);
        $vendedor->setEmpresa($empresa);
        $vendedor->setTaller($taller);
        $vendedor->setNit($nit);
        $vendedor->setCodigo($codigo);
        $vendedor->setComentarioFactura($comentarioFactura);
        $vendedor->setCuentaCUC($cuentaCUC);
        $vendedor->setNombrecuentaCUC($nombreCuentaCUC);
        $vendedor->setCuentaCUP($cuentaCUP);
        $vendedor->setNombrecuentaCUP($nombreCuentaCUP);
        $vendedor->setSucursal($sucursal);

        #actualizo la direccion 
        if (isset($id_provincia)) {
            $provincia = $this->obtenerProvincia($id_provincia);
            $vendedor->getDireccionEmpresa()->setProvincia($provincia);
        }
        if (isset($id_municipio)) {
            $municipio = $this->obtenerMunicipio($id_municipio);
            $vendedor->getDireccionEmpresa()->setMunicipio($municipio);
        }

        $vendedor->getDireccionEmpresa()->setDescripcion($ubicaDir);

        $em->flush();
    }

    private function listar() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Vendedor');
        $vendedores = $repository->findAll();

        return $vendedores;
    }

    private function obtener($idVendedor) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Vendedor');
        $vendedor = $repository->find($idVendedor);
        return $vendedor;
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
