<?php

namespace Eduardo\PerfilacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Municipio
 *
 * @ORM\Table(name="municipio")
 * @ORM\Entity
 */
class Municipio
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;


    /**
     * @ORM\ManyToOne(targetEntity="Provincia", inversedBy="municipios")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id", nullable=false)
     */
    private $provincia;
    
    public function __construct($nombre)
    {
        $this->nombre = $nombre;
    }
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
     * @return Municipio
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
     * Set provincia
     *
     * @param \Eduardo\PerfilacBundle\Entity\Provincia $provincia
     * @return Municipio
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
        return $this->nombre;
    }
}