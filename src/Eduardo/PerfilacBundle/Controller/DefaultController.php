<?php

namespace Eduardo\PerfilacBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $name = "Hola mundo";
        $msg = "";
        return $this->render('PerfilacBundle::index.html.twig', array('name' => $name, 'msg' => $msg));
    }
}
