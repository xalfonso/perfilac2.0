<?php

namespace Eduardo\PerfilacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductoVenta
 *
 * @ORM\Table(name="productoventa")
 * @ORM\Entity
 */
class ProductoVenta {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="cant", type="integer")
     */
    private $cant;

    /**
     * @var float
     *
     * @ORM\Column(name="ancho", type="float")
     */
    private $ancho;

    /**
     * @var float
     *
     * @ORM\Column(name="alto", type="float")
     */
    private $alto;

    /**
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id", nullable=false)
     */
    private $producto;

    /**
     * @ORM\ManyToOne(targetEntity="Venta", inversedBy="productosVenta")
     * @ORM\JoinColumn(name="venta_id", referencedColumnName="id", nullable=false)
     */
    private $venta;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set cant
     *
     * @param integer $cant
     * @return ProductoVenta
     */
    public function setCant($cant) {
        $this->cant = $cant;

        return $this;
    }

    /**
     * Get cant
     *
     * @return integer 
     */
    public function getCant() {
        return $this->cant;
    }

    /**
     * Set ancho
     *
     * @param float $ancho
     * @return ProductoVenta
     */
    public function setAncho($ancho) {
        $this->ancho = $ancho;

        return $this;
    }

    /**
     * Get ancho
     *
     * @return float 
     */
    public function getAncho() {
        return $this->ancho;
    }

    /**
     * Set alto
     *
     * @param float $alto
     * @return ProductoVenta
     */
    public function setAlto($alto) {
        $this->alto = $alto;

        return $this;
    }

    /**
     * Get alto
     *
     * @return float 
     */
    public function getAlto() {
        return $this->alto;
    }

    /**
     * Set producto
     *
     * @param \Eduardo\PerfilacBundle\Entity\Producto $producto
     * @return ProductoVenta
     */
    public function setProducto(\Eduardo\PerfilacBundle\Entity\Producto $producto) {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \Eduardo\PerfilacBundle\Entity\Producto 
     */
    public function getProducto() {
        return $this->producto;
    }

    /**
     * Set venta
     *
     * @param \Eduardo\PerfilacBundle\Entity\Venta $venta
     * @return ProductoVenta
     */
    public function setVenta(\Eduardo\PerfilacBundle\Entity\Venta $venta) {
        $this->venta = $venta;

        return $this;
    }

    /**
     * Get venta
     *
     * @return \Eduardo\PerfilacBundle\Entity\Venta 
     */
    public function getVenta() {
        return $this->venta;
    }

    public function metroCuadrados() {
        return ($this->ancho / 1000) * ($this->alto / 1000) * $this->cant;
    }

    public function precioCUP() {
        return $this->producto->getPrecioCUP() * $this->metroCuadrados() / $this->cant;
    }
    
    public function precioCUC() {
        return $this->producto->getPrecioCUC() * $this->metroCuadrados() / $this->cant;
    }
    public function importeCUP() {
        return $this->producto->getPrecioCUP() *  $this->cant;
    }
    public function importeCUC() {
        return $this->producto->getPrecioCUC() *  $this->cant;
    }

}