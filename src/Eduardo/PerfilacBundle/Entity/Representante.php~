<?php

namespace Eduardo\PerfilacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representante
 *
 * @ORM\Table(name="representante")
 * @ORM\Entity
 */
class Representante {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="primerNombre", type="string", length=255)
     */
    private $primerNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="segundoNombre", type="string", length=255)
     */
    private $segundoNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primerApellido", type="string", length=255)
     */
    private $primerApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundoApellido", type="string", length=255)
     */
    private $segundoApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="ci", type="string", length=11, unique=true)
     */
    private $ci;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;
    
    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255, nullable=true)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo", type="string", length=255)
     */
    private $cargo;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="representantes")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id", nullable=false)
     */
    private $cliente;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set primerNombre
     *
     * @param string $primerNombre
     * @return Representante
     */
    public function setPrimerNombre($primerNombre) {
        $this->primerNombre = $primerNombre;

        return $this;
    }

    /**
     * Get primerNombre
     *
     * @return string 
     */
    public function getPrimerNombre() {
        return $this->primerNombre;
    }

    /**
     * Set segundoNombre
     *
     * @param string $segundoNombre
     * @return Representante
     */
    public function setSegundoNombre($segundoNombre) {
        $this->segundoNombre = $segundoNombre;

        return $this;
    }

    /**
     * Get segundoNombre
     *
     * @return string 
     */
    public function getSegundoNombre() {
        return $this->segundoNombre;
    }

    /**
     * Set primerApellido
     *
     * @param string $primerApellido
     * @return Representante
     */
    public function setPrimerApellido($primerApellido) {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    /**
     * Get primerApellido
     *
     * @return string 
     */
    public function getPrimerApellido() {
        return $this->primerApellido;
    }

    /**
     * Set segundoApellido
     *
     * @param string $segundoApellido
     * @return Representante
     */
    public function setSegundoApellido($segundoApellido) {
        $this->segundoApellido = $segundoApellido;

        return $this;
    }

    /**
     * Get segundoApellido
     *
     * @return string 
     */
    public function getSegundoApellido() {
        return $this->segundoApellido;
    }

    public function getNombreCompleto() {
        return (($this->primerNombre!="") ? $this->primerNombre : "") ." ". (($this->segundoNombre!="") ? $this->segundoNombre : "") ." ". (($this->primerApellido!="") ? $this->primerApellido : "") ." ". (($this->segundoApellido!="") ? $this->segundoApellido : "") ;
    }

    /**
     * Set ci
     *
     * @param string $ci
     * @return Representante
     */
    public function setCi($ci) {
        $this->ci = $ci;

        return $this;
    }

    /**
     * Get ci
     *
     * @return string 
     */
    public function getCi() {
        return $this->ci;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Representante
     */
    public function setTelefono($telefono) {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     * @return Representante
     */
    public function setCargo($cargo) {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string 
     */
    public function getCargo() {
        return $this->cargo;
    }

    /**
     * Set cliente
     *
     * @param \Eduardo\PerfilacBundle\Entity\Cliente $cliente
     * @return Representante
     */
    public function setCliente(\Eduardo\PerfilacBundle\Entity\Cliente $cliente) {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \Eduardo\PerfilacBundle\Entity\Cliente 
     */
    public function getCliente() {
        return $this->cliente;
    }


    /**
     * Set correo
     *
     * @param string $correo
     * @return Representante
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    
        return $this;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getCorreo()
    {
        return $this->correo;
    }
}