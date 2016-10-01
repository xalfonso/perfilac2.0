<?php

namespace Eduardo\PerfilacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Direccion
 *
 * @ORM\Table(name="direccion")
 * @ORM\Entity
 */
class Direccion
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
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Municipio")
     * @ORM\JoinColumn(name="municipio_id", referencedColumnName="id", nullable=false)
     */
    private $municipio;
    
    /**
     * @ORM\ManyToOne(targetEntity="Provincia")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", nullable=false)
     */
    private $provincia;
    
    
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Direccion
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
     * Set municipio
     *
     * @param \Eduardo\PerfilacBundle\Entity\Municipio $municipio
     * @return Direccion
     */
    public function setMunicipio(\Eduardo\PerfilacBundle\Entity\Municipio $municipio)
    {
        $this->municipio = $municipio;
    
        return $this;
    }

    /**
     * Get municipio
     *
     * @return \Eduardo\PerfilacBundle\Entity\Municipio 
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set provincia
     *
     * @param \Eduardo\PerfilacBundle\Entity\Provincia $provincia
     * @return Direccion
     */
    public function setProvincia(\Eduardo\PerfilacBundle\Entity\Provincia $provincia)
    {
        $this->provincia = $provincia;
    
        return $this;
    }

    /**
     * Get provincia
     *
     * @return \Eduardo\PerfilacBundle\Entity\Provincia 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }
    
    
    public function __toString() {
        $dirCompleto = "";
       
        if($this->provincia)
            $dirCompleto = $dirCompleto.  $this->provincia.". ";
        if($this->municipio)
            $dirCompleto = $dirCompleto.  $this->municipio.". ";
        if($this->descripcion)
            $dirCompleto = $dirCompleto.  $this->descripcion.". ";
        return $dirCompleto;
    }
}