<?php

namespace Eduardo\PerfilacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comercial
 *
 * @ORM\Table(name="comercial")
 * @ORM\Entity
 */
class Comercial {

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
     * @ORM\Column(name="cargo", type="string", length=255)
     */
    private $cargo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255, nullable=true)
     */
    private $correo;

    /**
     * @ORM\OneToOne(targetEntity="Usuario" , cascade="all")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Vendedor", inversedBy="comerciales")
     * @ORM\JoinColumn(name="vendedor_id", referencedColumnName="id", nullable=false)
     */
    private $vendedor;

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
     * @return Comercial
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
     * @return Comercial
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
     * @return Comercial
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
     * @return Comercial
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

    /**
     * Set ci
     *
     * @param string $ci
     * @return Comercial
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
     * @return Comercial
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
     * @return Comercial
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
     * Set usuario
     *
     * @param \Eduardo\PerfilacBundle\Entity\Usuario $usuario
     * @return Comercial
     */
    public function setUsuario(\Eduardo\PerfilacBundle\Entity\Usuario $usuario) {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \Eduardo\PerfilacBundle\Entity\Usuario 
     */
    public function getUsuario() {
        return $this->usuario;
    }


    /**
     * Set vendedor
     *
     * @param \Eduardo\PerfilacBundle\Entity\Vendedor $vendedor
     * @return Comercial
     */
    public function setVendedor(\Eduardo\PerfilacBundle\Entity\Vendedor $vendedor)
    {
        $this->vendedor = $vendedor;
    
        return $this;
    }

    /**
     * Get vendedor
     *
     * @return \Eduardo\PerfilacBundle\Entity\Vendedor 
     */
    public function getVendedor()
    {
        return $this->vendedor;
    }

    /**
     * Set correo
     *
     * @param string $correo
     * @return Comercial
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
    
    public function getNombreCompleto() {
        return (($this->primerNombre!="") ? $this->primerNombre : "") ." ". (($this->segundoNombre!="") ? $this->segundoNombre : "") ." ". (($this->primerApellido!="") ? $this->primerApellido : "") ." ". (($this->segundoApellido!="") ? $this->segundoApellido : "") ;
    }
}