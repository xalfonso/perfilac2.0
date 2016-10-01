<?php

namespace Eduardo\PerfilacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venta
 *
 * @ORM\Table(name="venta")
 * @ORM\Entity
 */
class Venta {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255, unique=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="obra", type="string", length=255)
     */
    private $obra;

    /**
     * @var string
     *
     * @ORM\Column(name="ntransportador", type="string", length=255, nullable=true)
     */
    private $nombreTransportador;

    /**
     * @var string
     *
     * @ORM\Column(name="citransportador", type="string", length=11, nullable=true)
     */
    private $ciTransportador;

    /**
     * @var string
     *
     * @ORM\Column(name="chapatransportador", type="string", length=255, nullable=true)
     */
    private $chapaTransportador;
    /**
     * @var string
     *
     * @ORM\Column(name="licenciatransportador", type="string", length=255, nullable=true)
     */
    private $licenciaTransportador;
    /**
     * @var string
     *
     * @ORM\Column(name="cargotransportador", type="string", length=255, nullable=true)
     */
    private $cargoTransportador;

    /**
     * 
     * @ORM\OneToMany(targetEntity="Ingreso", mappedBy="venta", cascade="all")
     */
    private $ingresos;

    /**
     * @ORM\ManyToOne(targetEntity="TipoVenta")
     * @ORM\JoinColumn(name="tipoventa_id", referencedColumnName="id", nullable=false)
     */
    private $tipoVenta;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id", nullable=false)
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="Representante")
     * @ORM\JoinColumn(name="representante_id", referencedColumnName="id", nullable=false)
     */
    private $representante;

    /**
     * @ORM\ManyToOne(targetEntity="Vendedor")
     * @ORM\JoinColumn(name="vendedor_id", referencedColumnName="id", nullable=false)
     */
    private $vendedor;

    /**
     * @ORM\ManyToOne(targetEntity="Comercial")
     * @ORM\JoinColumn(name="comercial_id", referencedColumnName="id", nullable=false)
     */
    private $comercial;

    /**
     * 
     * @ORM\OneToMany(targetEntity="ProductoVenta", mappedBy="venta", cascade="all")
     */
    private $productosVenta;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Venta
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->ingresos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productosVenta = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ingresos
     *
     * @param \Eduardo\PerfilacBundle\Entity\Ingreso $ingresos
     * @return Venta
     */
    public function addIngreso(\Eduardo\PerfilacBundle\Entity\Ingreso $ingresos) {
        $this->ingresos[] = $ingresos;

        return $this;
    }

    /**
     * Remove ingresos
     *
     * @param \Eduardo\PerfilacBundle\Entity\Ingreso $ingresos
     */
    public function removeIngreso(\Eduardo\PerfilacBundle\Entity\Ingreso $ingresos) {
        $this->ingresos->removeElement($ingresos);
    }

    /**
     * Get ingresos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngresos() {
        return $this->ingresos;
    }

    /**
     * Set tipoVenta
     *
     * @param \Eduardo\PerfilacBundle\Entity\TipoVenta $tipoVenta
     * @return Venta
     */
    public function setTipoVenta(\Eduardo\PerfilacBundle\Entity\TipoVenta $tipoVenta) {
        $this->tipoVenta = $tipoVenta;

        return $this;
    }

    /**
     * Get tipoVenta
     *
     * @return \Eduardo\PerfilacBundle\Entity\TipoVenta 
     */
    public function getTipoVenta() {
        return $this->tipoVenta;
    }

    /**
     * Set cliente
     *
     * @param \Eduardo\PerfilacBundle\Entity\Cliente $cliente
     * @return Venta
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
     * Add productosVenta
     *
     * @param \Eduardo\PerfilacBundle\Entity\ProductoVenta $productosVenta
     * @return Venta
     */
    public function addProductosVenta(\Eduardo\PerfilacBundle\Entity\ProductoVenta $productosVenta) {
        $this->productosVenta[] = $productosVenta;

        return $this;
    }

    /**
     * Remove productosVenta
     *
     * @param \Eduardo\PerfilacBundle\Entity\ProductoVenta $productosVenta
     */
    public function removeProductosVenta(\Eduardo\PerfilacBundle\Entity\ProductoVenta $productosVenta) {
        $this->productosVenta->removeElement($productosVenta);
    }

    /**
     * Get productosVenta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductosVenta() {
        return $this->productosVenta;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return Venta
     */
    public function setNumero($numero) {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero() {
        return $this->numero;
    }

    /**
     * Set representante
     *
     * @param \Eduardo\PerfilacBundle\Entity\Representante $representante
     * @return Venta
     */
    public function setRepresentante(\Eduardo\PerfilacBundle\Entity\Representante $representante) {
        $this->representante = $representante;

        return $this;
    }

    public function getFechaString() {
        return $this->fecha->format("d/m/y");
    }

    /**
     * Get representante
     *
     * @return \Eduardo\PerfilacBundle\Entity\Representante 
     */
    public function getRepresentante() {
        return $this->representante;
    }

    public function cantProductos() {
        $cantProductos = 0;
        foreach ($this->productosVenta as $prodVenta) {
            $cantProductos += $prodVenta->getCant();
        }
        return $cantProductos;
    }

    public function metrosCuadrados() {
        $metrosCuadrado = 0.00;
        foreach ($this->productosVenta as $prodVenta) {
            $metrosCuadrado += $prodVenta->metroCuadrados();
        }
        return $metrosCuadrado;
    }

    public function importeCUC() {
        $importeCUC = 0.00;
        foreach ($this->productosVenta as $prodVenta) {
            $importeCUC += $prodVenta->importeCUC();
        }
        return $importeCUC;
    }

    public function importeCUP() {
        $importeCUP = 0.00;
        foreach ($this->productosVenta as $prodVenta) {
            $importeCUP += $prodVenta->importeCUP();
        }
        return $importeCUP;
    }

    public function importeTotal() {
        $importeTotal = $this->importeCUC() + $this->importeCUP();
        return $importeTotal;
    }

    /**
     * Set obra
     *
     * @param string $obra
     * @return Venta
     */
    public function setObra($obra) {
        $this->obra = $obra;

        return $this;
    }

    /**
     * Get obra
     *
     * @return string 
     */
    public function getObra() {
        return $this->obra;
    }

    /**
     * Set vendedor
     *
     * @param \Eduardo\PerfilacBundle\Entity\Vendedor $vendedor
     * @return Venta
     */
    public function setVendedor(\Eduardo\PerfilacBundle\Entity\Vendedor $vendedor) {
        $this->vendedor = $vendedor;

        return $this;
    }

    /**
     * Get vendedor
     *
     * @return \Eduardo\PerfilacBundle\Entity\Vendedor 
     */
    public function getVendedor() {
        return $this->vendedor;
    }

    /**
     * Set comercial
     *
     * @param \Eduardo\PerfilacBundle\Entity\Comercial $comercial
     * @return Venta
     */
    public function setComercial(\Eduardo\PerfilacBundle\Entity\Comercial $comercial) {
        $this->comercial = $comercial;

        return $this;
    }

    /**
     * Get comercial
     *
     * @return \Eduardo\PerfilacBundle\Entity\Comercial 
     */
    public function getComercial() {
        return $this->comercial;
    }


    /**
     * Set nombreTransportador
     *
     * @param string $nombreTransportador
     * @return Venta
     */
    public function setNombreTransportador($nombreTransportador)
    {
        $this->nombreTransportador = $nombreTransportador;
    
        return $this;
    }

    /**
     * Get nombreTransportador
     *
     * @return string 
     */
    public function getNombreTransportador()
    {
        return $this->nombreTransportador;
    }

    /**
     * Set ciTransportador
     *
     * @param string $ciTransportador
     * @return Venta
     */
    public function setCiTransportador($ciTransportador)
    {
        $this->ciTransportador = $ciTransportador;
    
        return $this;
    }

    /**
     * Get ciTransportador
     *
     * @return string 
     */
    public function getCiTransportador()
    {
        return $this->ciTransportador;
    }

    /**
     * Set chapaTransportador
     *
     * @param string $chapaTransportador
     * @return Venta
     */
    public function setChapaTransportador($chapaTransportador)
    {
        $this->chapaTransportador = $chapaTransportador;
    
        return $this;
    }

    /**
     * Get chapaTransportador
     *
     * @return string 
     */
    public function getChapaTransportador()
    {
        return $this->chapaTransportador;
    }

    /**
     * Set licenciaTransportador
     *
     * @param string $licenciaTransportador
     * @return Venta
     */
    public function setLicenciaTransportador($licenciaTransportador)
    {
        $this->licenciaTransportador = $licenciaTransportador;
    
        return $this;
    }

    /**
     * Get licenciaTransportador
     *
     * @return string 
     */
    public function getLicenciaTransportador()
    {
        return $this->licenciaTransportador;
    }

    /**
     * Set cargoTransportador
     *
     * @param string $cargoTransportador
     * @return Venta
     */
    public function setCargoTransportador($cargoTransportador)
    {
        $this->cargoTransportador = $cargoTransportador;
    
        return $this;
    }

    /**
     * Get cargoTransportador
     *
     * @return string 
     */
    public function getCargoTransportador()
    {
        return $this->cargoTransportador;
    }
}