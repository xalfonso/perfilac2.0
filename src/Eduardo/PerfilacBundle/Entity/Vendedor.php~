<?php

namespace Eduardo\PerfilacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vendedor
 *
 * @ORM\Table(name="vendedor")
 * @ORM\Entity
 */
class Vendedor
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
     * @ORM\Column(name="grupoEmpresarial", type="string", length=255)
     */
    private $grupoEmpresarial;

    /**
     * @var string
     *
     * @ORM\Column(name="empresa", type="string", length=255)
     */
    private $empresa;

    /**
     * @var string
     *
     * @ORM\Column(name="taller", type="string", length=255)
     */
    private $taller;

    /**
     * @ORM\OneToOne(targetEntity="Direccion", cascade="all")
     * @ORM\JoinColumn(name="direccion_id", referencedColumnName="id",  nullable=false)
     */
    private $direccionEmpresa;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="sucursal", type="string", length=255)
     */
    private $sucursal;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cuentaCUP", type="string", length=255)
     */
    private $cuentaCUP;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombrecuentaCUP", type="string", length=255)
     */
    private $nombrecuentaCUP;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cuentaCUC", type="string", length=255)
     */
    private $cuentaCUC;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombrecuentaCUC", type="string", length=255)
     */
    private $nombrecuentaCUC;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=255)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="comentariofactura", type="text")
     */
    private $comentarioFactura;
    
    
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Comercial", mappedBy="vendedor", cascade="all")
     */
    private $comerciales;
    
    
    
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
     * Set grupoEmpresarial
     *
     * @param string $grupoEmpresarial
     * @return Vendedor
     */
    public function setGrupoEmpresarial($grupoEmpresarial)
    {
        $this->grupoEmpresarial = $grupoEmpresarial;
    
        return $this;
    }

    /**
     * Get grupoEmpresarial
     *
     * @return string 
     */
    public function getGrupoEmpresarial()
    {
        return $this->grupoEmpresarial;
    }

    /**
     * Set empresa
     *
     * @param string $empresa
     * @return Vendedor
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
    
        return $this;
    }

    /**
     * Get empresa
     *
     * @return string 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set taller
     *
     * @param string $taller
     * @return Vendedor
     */
    public function setTaller($taller)
    {
        $this->taller = $taller;
    
        return $this;
    }

    /**
     * Get taller
     *
     * @return string 
     */
    public function getTaller()
    {
        return $this->taller;
    }

    
    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Vendedor
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
     * Set sucursal
     *
     * @param string $sucursal
     * @return Vendedor
     */
    public function setSucursal($sucursal)
    {
        $this->sucursal = $sucursal;
    
        return $this;
    }

    /**
     * Get sucursal
     *
     * @return string 
     */
    public function getSucursal()
    {
        return $this->sucursal;
    }

    /**
     * Set cuentaCUP
     *
     * @param string $cuentaCUP
     * @return Vendedor
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
     * Set nombrecuentaCUP
     *
     * @param string $nombrecuentaCUP
     * @return Vendedor
     */
    public function setNombrecuentaCUP($nombrecuentaCUP)
    {
        $this->nombrecuentaCUP = $nombrecuentaCUP;
    
        return $this;
    }

    /**
     * Get nombrecuentaCUP
     *
     * @return string 
     */
    public function getNombrecuentaCUP()
    {
        return $this->nombrecuentaCUP;
    }

    /**
     * Set cuentaCUC
     *
     * @param string $cuentaCUC
     * @return Vendedor
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
     * Set nombrecuentaCUC
     *
     * @param string $nombrecuentaCUC
     * @return Vendedor
     */
    public function setNombrecuentaCUC($nombrecuentaCUC)
    {
        $this->nombrecuentaCUC = $nombrecuentaCUC;
    
        return $this;
    }

    /**
     * Get nombrecuentaCUC
     *
     * @return string 
     */
    public function getNombrecuentaCUC()
    {
        return $this->nombrecuentaCUC;
    }

    /**
     * Set nit
     *
     * @param string $nit
     * @return Vendedor
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
     * Set comentarioFactura
     *
     * @param string $comentarioFactura
     * @return Vendedor
     */
    public function setComentarioFactura($comentarioFactura)
    {
        $this->comentarioFactura = $comentarioFactura;
    
        return $this;
    }

    /**
     * Get comentarioFactura
     *
     * @return string 
     */
    public function getComentarioFactura()
    {
        return $this->comentarioFactura;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comerciales = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add comerciales
     *
     * @param \Eduardo\PerfilacBundle\Entity\Comercial $comerciales
     * @return Vendedor
     */
    public function addComerciale(\Eduardo\PerfilacBundle\Entity\Comercial $comerciales)
    {
        $this->comerciales[] = $comerciales;
    
        return $this;
    }

    /**
     * Remove comerciales
     *
     * @param \Eduardo\PerfilacBundle\Entity\Comercial $comerciales
     */
    public function removeComerciale(\Eduardo\PerfilacBundle\Entity\Comercial $comerciales)
    {
        $this->comerciales->removeElement($comerciales);
    }

    /**
     * Get comerciales
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComerciales()
    {
        return $this->comerciales;
    }

    /**
     * Set direccionEmpresa
     *
     * @param \Eduardo\PerfilacBundle\Entity\Direccion $direccionEmpresa
     * @return Vendedor
     */
    public function setDireccionEmpresa(\Eduardo\PerfilacBundle\Entity\Direccion $direccionEmpresa)
    {
        $this->direccionEmpresa = $direccionEmpresa;
    
        return $this;
    }

    /**
     * Get direccionEmpresa
     *
     * @return \Eduardo\PerfilacBundle\Entity\Direccion 
     */
    public function getDireccionEmpresa()
    {
        return $this->direccionEmpresa;
    }
}