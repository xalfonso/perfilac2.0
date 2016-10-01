<?php

namespace Eduardo\PerfilacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingreso
 *
 * @ORM\Table(name="ingreso")
 * @ORM\Entity
 */
class Ingreso
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
     * @var float
     *
     * @ORM\Column(name="importe", type="float")
     */
    private $importe;

    /**
     * @var string
     *
     * @ORM\Column(name="cheque", type="string", length=255)
     */
    private $cheque;

    
    /**
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id", nullable=false)
     */
    private $cliente;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="TipoMoneda")
     * @ORM\JoinColumn(name="tipomoneda_id", referencedColumnName="id", nullable=false)
     */
    private $tipoMoneda;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Venta", inversedBy="ingresos")
     * @ORM\JoinColumn(name="venta_id", referencedColumnName="id", nullable=false)
     */
    private $venta;

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
     * Set importe
     *
     * @param float $importe
     * @return Ingreso
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;
    
        return $this;
    }

    /**
     * Get importe
     *
     * @return float 
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set cheque
     *
     * @param string $cheque
     * @return Ingreso
     */
    public function setCheque($cheque)
    {
        $this->cheque = $cheque;
    
        return $this;
    }

    /**
     * Get cheque
     *
     * @return string 
     */
    public function getCheque()
    {
        return $this->cheque;
    }

    /**
     * Set cliente
     *
     * @param \Eduardo\PerfilacBundle\Entity\Cliente $cliente
     * @return Ingreso
     */
    public function setCliente(\Eduardo\PerfilacBundle\Entity\Cliente $cliente)
    {
        $this->cliente = $cliente;
    
        return $this;
    }

    /**
     * Get cliente
     *
     * @return \Eduardo\PerfilacBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set tipoMoneda
     *
     * @param \Eduardo\PerfilacBundle\Entity\TipoMoneda $tipoMoneda
     * @return Ingreso
     */
    public function setTipoMoneda(\Eduardo\PerfilacBundle\Entity\TipoMoneda $tipoMoneda)
    {
        $this->tipoMoneda = $tipoMoneda;
    
        return $this;
    }

    /**
     * Get tipoMoneda
     *
     * @return \Eduardo\PerfilacBundle\Entity\TipoMoneda 
     */
    public function getTipoMoneda()
    {
        return $this->tipoMoneda;
    }

    /**
     * Set venta
     *
     * @param \Eduardo\PerfilacBundle\Entity\Venta $venta
     * @return Ingreso
     */
    public function setVenta(\Eduardo\PerfilacBundle\Entity\Venta $venta)
    {
        $this->venta = $venta;
    
        return $this;
    }

    /**
     * Get venta
     *
     * @return \Eduardo\PerfilacBundle\Entity\Venta 
     */
    public function getVenta()
    {
        return $this->venta;
    }
}