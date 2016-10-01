<?php

namespace Eduardo\PerfilacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity
 */
class Cliente
{
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
     * @ORM\Column(name="codigo", type="string", length=255, unique=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="contrato", type="string", length=255)
     */
    private $contrato;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=255)
     */
    private $nit;
    
    /**
     * @var string
     *
     * @ORM\Column(name="suplemento", type="string", length=255)
     */
    private $suplemento;

    /**
     * @var string
     *
     * @ORM\Column(name="cuentaCUC", type="string", length=255)
     */
    private $cuentaCUC;

    /**
     * @var string
     *
     * @ORM\Column(name="cuentaCUP", type="string", length=255)
     */
    private $cuentaCUP;

    /**
     * 
     * @ORM\OneToMany(targetEntity="Representante", mappedBy="cliente", cascade="all")
     */
    private $representantes;
    
   
    /**
     * @ORM\OneToOne(targetEntity="Direccion", cascade="all")
     * @ORM\JoinColumn(name="direccion_id", referencedColumnName="id",  nullable=false)
     */
    private $direccion;
    
     
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Cliente
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Cliente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set contrato
     *
     * @param string $contrato
     * @return Cliente
     */
    public function setContrato($contrato)
    {
        $this->contrato = $contrato;
    
        return $this;
    }

    /**
     * Get contrato
     *
     * @return string 
     */
    public function getContrato()
    {
        return $this->contrato;
    }

    /**
     * Set cuentaCUC
     *
     * @param string $cuentaCUC
     * @return Cliente
     */
    public function setCuentaCUC($cuentaCUC)
    {
        $this->cuentaCUC = $cuentaCUC;
    
        return $this;
    }

    /**
     * Get cuentaCUC
     *
     * @return string 
     */
    public function getCuentaCUC()
    {
        return $this->cuentaCUC;
    }

    /**
     * Set cuentaCUP
     *
     * @param string $cuentaCUP
     * @return Cliente
     */
    public function setCuentaCUP($cuentaCUP)
    {
        $this->cuentaCUP = $cuentaCUP;
    
        return $this;
    }

    /**
     * Get cuentaCUP
     *
     * @return string 
     */
    public function getCuentaCUP()
    {
        return $this->cuentaCUP;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->representantes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add representantes
     *
     * @param \Eduardo\PerfilacBundle\Entity\Representante $representantes
     * @return Cliente
     */
    public function addRepresentante(\Eduardo\PerfilacBundle\Entity\Representante $representantes)
    {
        $this->representantes[] = $representantes;
    
        return $this;
    }

    /**
     * Remove representantes
     *
     * @param \Eduardo\PerfilacBundle\Entity\Representante $representantes
     */
    public function removeRepresentante(\Eduardo\PerfilacBundle\Entity\Representante $representantes)
    {
        $this->representantes->removeElement($representantes);
    }

    /**
     * Get representantes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRepresentantes()
    {
        return $this->representantes;
    }

    /**
     * Set direccion
     *
     * @param \Eduardo\PerfilacBundle\Entity\Direccion $direccion
     * @return Cliente
     */
    public function setDireccion(\Eduardo\PerfilacBundle\Entity\Direccion $direccion)
    {
        $this->direccion = $direccion;
    
        return $this;
    }

    /**
     * Get direccion
     *
     * @return \Eduardo\PerfilacBundle\Entity\Direccion 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    

    /**
     * Set nit
     *
     * @param string $nit
     * @return Cliente
     */
    public function setNit($nit)
    {
        $this->nit = $nit;
    
        return $this;
    }

    /**
     * Get nit
     *
     * @return string 
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set suplemento
     *
     * @param string $suplemento
     * @return Cliente
     */
    public function setSuplemento($suplemento)
    {
        $this->suplemento = $suplemento;
    
        return $this;
    }

    /**
     * Get suplemento
     *
     * @return string 
     */
    public function getSuplemento()
    {
        return $this->suplemento;
    }
}