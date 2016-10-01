<?php

namespace Eduardo\PerfilacBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eduardo\PerfilacBundle\Entity\Vendedor;
use Eduardo\PerfilacBundle\Entity\Comercial;
use Eduardo\PerfilacBundle\Entity\Usuario;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Eduardo\PerfilacBundle\Util\Estandar;

/**
 * Controlador para el comercial
 * @author Eduardo Alfonso <eddie.alfonso@gmail.com>
 */
class ComercialController extends Controller {

    public function incluirAction($accion) {

        #cargo los vendedores
        $vendedores = $this->listarVendedores();

        #para comenzar a insertar 
        $msg = "";
        if ($accion == 'ini')
            return $this->render('PerfilacBundle:vendedor:incluirComercial.html.twig', array('msg' => $msg, 'vendedores' => $vendedores));

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
                $idVendedor = $request->request->get('name_vendedores');
                $vendedor = $this->obtenerVendedor($idVendedor);

                //datos del usuario
                $user = $request->request->get('name_usuario');
                $pass = $request->request->get('name_pass');
                $rol = $request->request->get('name_roles');

                $this->salvar($nombre, $snombre, $apellido, $sapellido, $ci, $te, $correo, $cargo, $vendedor, $user, $pass, $rol);
                $msg = Estandar::msg_DatosIncluidos;
            }

            return $this->render('PerfilacBundle:vendedor:incluirComercial.html.twig', array('msg' => $msg, 'vendedores' => $vendedores));
        }

        #si no cumple con ninguno de los parametros lo redirecciono para el inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function modificarAction($id) {

        $msg = "";
        $comercial = $this->obtener($id);
        if ($comercial != NULL) {
            #cargo los clientes
            $vendedores = $this->listarVendedores();
            return $this->render('PerfilacBundle:vendedor:modificarComercial.html.twig', array('msg' => $msg, 'comercial' => $comercial, 'vendedores' => $vendedores));
        } else {
            #en caso que no exista un objeto con tal id redirecciono para el listar
            return new RedirectResponse($this->generateUrl('comercialListar'));
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
            $correo = $request->request->get('name_correo');
            $cargo = $request->request->get('name_cargo');
            $idVendedor = $request->request->get('name_vendedores');
            $vendedor = $this->obtenerVendedor($idVendedor);

            //datos del usuario
            $user = $request->request->get('name_usuario');
            $pass = $request->request->get('name_pass');
            $rol = $request->request->get('name_roles');
            $cambiarPass = $request->request->get('name_habilitarModificarPass');


            $this->actualizar($id, $nombre, $snombre, $apellido, $sapellido, $ci, $te, $correo, $cargo, $vendedor, $user, $pass, $rol, $cambiarPass);
            $msg = Estandar::msg_DatosActualizados;
        }
        #Despues de actualizar lo redirecciono al inicio
        return new RedirectResponse($this->generateUrl('perfilac_homepage'));
    }

    public function listarAction() {
        $paginator = $this->get("ideup.simple_paginator");
        $listComerciales = $paginator->paginate($this->listar())->getResult();
        $msg = "";
        return $this->render('PerfilacBundle:vendedor:listarComercial.html.twig', array('comerciales' => $listComerciales, 'msg' => $msg));
    }

    #metodos para el trabajo con la base de datos

    private function salvar($nombre, $snombre, $apellido, $sapellido, $ci, $te, $correo, $cargo, $vendedor, $user, $pass, $rol) {
        $em = $this->getDoctrine()->getManager();

        $comercial = new Comercial();
        $comercial->setPrimerNombre($nombre);
        $comercial->setSegundoNombre($snombre);
        $comercial->setPrimerApellido($apellido);
        $comercial->setSegundoApellido($sapellido);
        $comercial->setCi($ci);
        $comercial->setTelefono($te);
        $comercial->setCargo($cargo);
        $comercial->setCorreo($correo);
        $comercial->setVendedor($vendedor);

        //datos del usuario
        $usuario = new Usuario();
        $usuario->setUsername($user);
        $usuario->setPassword($pass);
        $usuario->setRol($rol);

        #codificar la constraseña con el algoritmo configurado en security
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($usuario);
        $passCodificada = $encoder->encodePassword($usuario->getPassword(), $usuario->getSalt());
        $usuario->setPassword($passCodificada);

        $comercial->setUsuario($usuario);

        $em->persist($comercial);
        $em->flush();
    }

    private function actualizar($id, $nombre, $snombre, $apellido, $sapellido, $ci, $te, $correo, $cargo, $vendedor, $user, $pass, $rol, $cambiarPass) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Comercial');
        $comercial = $repository->find($id);
        #Datos generales
        $comercial->setPrimerNombre($nombre);
        $comercial->setSegundoNombre($snombre);
        $comercial->setPrimerApellido($apellido);
        $comercial->setSegundoApellido($sapellido);
        $comercial->setCi($ci);
        $comercial->setTelefono($te);
        $comercial->setCargo($cargo);
        $comercial->setCorreo($correo);
        $comercial->setVendedor($vendedor);
        //datos del usuario
        $comercial->getUsuario()->setUsername($user);
        $comercial->getUsuario()->setRol($rol);

        #si está habilitado el cambiar contraseña la actualizo en la base de datos
        if ($cambiarPass) {
            $comercial->getUsuario()->setPassword($pass);
            #codificar la constraseña con el algoritmo configurado en security
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($comercial->getUsuario());
            $passCodificada = $encoder->encodePassword($comercial->getUsuario()->getPassword(), $comercial->getUsuario()->getSalt());
            $comercial->getUsuario()->setPassword($passCodificada);
        }
        $em->flush();
    }

    private function listar() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Comercial');
        $comerciales = $repository->findAll();
        return $comerciales;
    }

    private function obtener($idComercial) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Comercial');
        $comercial = $repository->find($idComercial);
        return $comercial;
    }

    private function listarVendedores() {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Vendedor');
        $vendedores = $repository->findBy(array(), array('codigo' => 'ASC'));
        return $vendedores;
    }

    private function obtenerVendedor($id) {
        $repository = $this->getDoctrine()->getRepository('PerfilacBundle:Vendedor');
        $vendedor = $repository->find($id);
        return $vendedor;
    }

}
