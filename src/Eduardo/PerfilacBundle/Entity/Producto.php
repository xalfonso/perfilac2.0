<?php

namespace Eduardo\PerfilacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table(name="producto")
 * @ORM\Entity
 */
class Producto
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
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="noFicha", type="integer")
     */
    private $noFicha;

    /**
     * @var float
     *
     * @ORM\Column(name="precioCUC", type="float")
     */
    private $precioCUC;

    /**
     * @var float
     *
     * @ORM\Column(name="precioCUP", type="float")
     */
    private $precioCUP;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

  
    /**
     * @ORM\ManyToOne(targetEntity="TipoProducto")
     * @ORM\JoinColumn(name="tipoproducto_id", referencedColumnName="id", nullable=false)
     */
    private $tipoProducto;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="TipoEnchape")
     * @ORM\JoinColumn(name="tipoenchape_id", referencedColumnName="id", nullable=false)
     */
    private $tipoEnchape;
    
    /**
     * @ORM\ManyToOne(targetEntity="Suministrador")
     * @ORM\JoinColumn(name="suministrador_id", referencedColumnName="id", nullable=false)
     */
    private $suministrador;
    
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
     * @return Producto
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Producto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set noFicha
     *
     * @param integer $noFicha
     * @return Producto
     */
    public function setNoFicha($noFicha)
    {
        $this->noFicha = $noFicha;
    
        return $this;
    }

    /**
     * Get noFicha
     *
     * @return integer 
     */
    public function getNoFicha()
    {
        return $this->noFicha;
    }

    /**
     * Set precioCUC
     *
     * @param float $precioCUC
     * @return Producto
     */
    public function setPrecioCUC($precioCUC)
    {
        $this->precioCUC = $precioCUC;
    
        return $this;
    }

    /**
     * Get precioCUC
     *
     * @return float 
     */
    public function getPrecioCUC()
    {
        return $this->precioCUC;
    }

    /**
     * Set precioCUP
     *
     * @param float $precioCUP
     * @return Producto
     */
    public function setPrecioCUP($precioCUP)
    {
        $this->precioCUP = $precioCUP;
    
        return $this;
    }

    /**
     * Get precioCUP
     *
     * @return float 
     */
    public function getPrecioCUP()
    {
        return $this->precioCUP;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return Producto
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set tipoProducto
     *
     * @param \Eduardo\PerfilacBundle\Entity\TipoProducto $tipoProducto
     * @return Producto
     */
    public function setTipoProducto(\Eduardo\PerfilacBundle\Entity\TipoProducto $tipoProducto)
    {
        $this->tipoProducto = $tipoProducto;
    
        return $this;
    }

    /**
     * Get tipoProducto
     *
     * @return \Eduardo\PerfilacBundle\Entity\TipoProducto 
     */
    public function getTipoProducto()
    {
        return $this->tipoProducto;
    }

    /**
     * Set tipoEnchape
     *
     * @param \Eduardo\PerfilacBundle\Entity\TipoEnchape $tipoEnchape
     * @return Producto
     */
    public function setTipoEnchape(\Eduardo\PerfilacBundle\Entity\TipoEnchape $tipoEnchape)
    {
        $this->tipoEnchape = $tipoEnchape;
    
        return $this;
    }

    /**
     * Get tipoEnchape
     *
     * @return \Eduardo\PerfilacBundle\Entity\TipoEnchape 
     */
    public function getTipoEnchape()
    {
        return $this->tipoEnchape;
    }

    /**
     * Set suministrador
     *
     * @param \Eduardo\PerfilacBundle\Entity\Suministrador $suministrador
     * @return Producto
     */
    public function setSuministrador(\Eduardo\PerfilacBundle\Entity\Suministrador $suministrador)
    {
        $this->suministrador = $suministrador;
    
        return $this;
    }

    /**
     * Get suministrador
     *
     * @return \Eduardo\PerfilacBundle\Entity\Suministrador 
     */
    public function getSuministrador()
    {
        return $this->suministrador;
    }
    
    public function __toString() {
        return $this->codigo. " ". $this->color;
    }
     
}