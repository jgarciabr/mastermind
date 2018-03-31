<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restricciones
 *
 * @ORM\Table(name="restricciones")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RestriccionesRepository")
 */
class Restricciones
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="maxsessions", type="integer")
     */
    private $maxsessions;

    /**
     * @var int
     *
     * @ORM\Column(name="numelements", type="integer")
     */
    private $numelements;

    /**
     * @var int
     *
     * @ORM\Column(name="numcolors", type="integer")
     */
    private $numcolors;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set maxsessions
     *
     * @param integer $maxsessions
     *
     * @return Restricciones
     */
    public function setMaxsessions($maxsessions)
    {
        $this->maxsessions = $maxsessions;

        return $this;
    }

    /**
     * Get maxsessions
     *
     * @return int
     */
    public function getMaxsessions()
    {
        return $this->maxsessions;
    }

    /**
     * Set numelements
     *
     * @param integer $numelements
     *
     * @return Restricciones
     */
    public function setNumelements($numelements)
    {
        $this->numelements = $numelements;

        return $this;
    }

    /**
     * Get numelements
     *
     * @return int
     */
    public function getNumelements()
    {
        return $this->numelements;
    }

    /**
     * Set numcolors
     *
     * @param integer $numcolors
     *
     * @return Restricciones
     */
    public function setNumcolors($numcolors)
    {
        $this->numcolors = $numcolors;

        return $this;
    }

    /**
     * Get numcolors
     *
     * @return int
     */
    public function getNumcolors()
    {
        return $this->numcolors;
    }
}

