<?php

namespace Eduardo\PerfilacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provincia
 *
 * @ORM\Table(name="provincia")
 * @ORM\Entity
 */
class Provincia
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
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * 
     *
     * @ORM\OneToMany(targetEntity="Municipio", mappedBy="provincia")
     */
    private $municipios;

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
     * Set nombre
     *
     * @param string $nombre
     * @return Provincia
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
     * Constructor
     */
    public function __construct()
    {
        $this->municipios = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add municipios
     *
     * @param \Eduardo\PerfilacBundle\Entity\Municipio $municipios
     * @return Provincia
     */
    public function addMunicipio(\Eduardo\PerfilacBundle\Entity\Municipio $municipios)
    {
        $this->municipios[] = $municipios;
    
        return $this;
    }

    /**
     * Remove municipios
     *
     * @param \Eduardo\PerfilacBundle\Entity\Municipio $municipios
     */
    public function removeMunicipio(\Eduardo\PerfilacBundle\Entity\Municipio $municipios)
    {
        $this->municipios->removeElement($municipios);
    }

    /**
     * Get municipios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMunicipios()
    {
        return $this->municipios;
    }
    
    public function __toString() {
        return $this->nombre;
    }
}