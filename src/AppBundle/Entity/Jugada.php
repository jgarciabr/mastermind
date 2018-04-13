<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jugada
 *
 * @ORM\Table(name="jugada")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JugadaRepository")
 */
class Jugada
{

    /**
     * @ORM\ManyToOne(targetEntity="Partida", inversedBy="jugadas")
     * @ORM\JoinColumn(name="partidaId", referencedColumnName="id")
     */
    private $partida;

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
     * @ORM\Column(name="num", type="integer")
     */
    private $num;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime",nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="code1", type="string", length=255)
     */
    private $code1;
    /**
     * @var string
     *
     * @ORM\Column(name="code2", type="string", length=255)
     */
    private $code2;
    /**
     * @var string
     *
     * @ORM\Column(name="code3", type="string", length=255)
     */
    private $code3;
    /**
     * @var string
     *
     * @ORM\Column(name="code4", type="string", length=255)
     */
    private $code4;
    /**
     * @var string
     *
     * @ORM\Column(name="code5", type="string", length=255)
     */
    private $code5;    /**
 * @var string
 *
 * @ORM\Column(name="code6", type="string", length=255)
 */
    private $code6;

    /**
     * @var string
     *
     * @ORM\Column(name="result", type="string", length=255)
     */
    private $result;

    /**
     * @var int
     *
     * @ORM\Column(name="partidaId", type="integer")
     */
    private $partidaId;


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
     * Set num
     *
     * @param integer $num
     *
     * @return Jugada
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return int
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Jugada
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set code
     *
     * @param array $code
     *
     * @return Jugada
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return array
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set result
     *
     * @param array $result
     *
     * @return Jugada
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set partidaId
     *
     * @param integer $partidaId
     *
     * @return Jugada
     */
    public function setPartidaId($partidaId)
    {
        $this->partidaId = $partidaId;
        return $this;
    }

    /**
     * Get partidaId
     *
     * @return int
     */

    public function getPartidaId()
    {
        return $this->partidaId;
    }

    /**
     * Set survey
     *
     * @param \AppBundle\Entity\Partida $partida
     *
     * @return Choice
     */

    public function setPartida(\AppBundle\Entity\Partida $partida)
    {
        $this->partida = $partida;

        return $this;
    }

    /**
     * Get surveyId
     *
     * @return \AppBundle\Entity\Partida
     */

    public function getPartida()
    {
        return $this->partida;
    }


    /**
     * Set code1
     *
     * @param string $code1
     *
     * @return Jugada
     */
    public function setCode1($code1)
    {
        $this->code1 = $code1;

        return $this;
    }

    /**
     * Get code1
     *
     * @return string
     */
    public function getCode1()
    {
        return $this->code1;
    }

    /**
     * Set code2
     *
     * @param string $code2
     *
     * @return Jugada
     */
    public function setCode2($code2)
    {
        $this->code2 = $code2;

        return $this;
    }

    /**
     * Get code2
     *
     * @return string
     */
    public function getCode2()
    {
        return $this->code2;
    }

    /**
     * Set code3
     *
     * @param string $code3
     *
     * @return Jugada
     */
    public function setCode3($code3)
    {
        $this->code3 = $code3;

        return $this;
    }

    /**
     * Get code3
     *
     * @return string
     */
    public function getCode3()
    {
        return $this->code3;
    }

    /**
     * Set code4
     *
     * @param string $code4
     *
     * @return Jugada
     */
    public function setCode4($code4)
    {
        $this->code4 = $code4;

        return $this;
    }

    /**
     * Get code4
     *
     * @return string
     */
    public function getCode4()
    {
        return $this->code4;
    }

    /**
     * Set code5
     *
     * @param string $code5
     *
     * @return Jugada
     */
    public function setCode5($code5)
    {
        $this->code5 = $code5;

        return $this;
    }

    /**
     * Get code5
     *
     * @return string
     */
    public function getCode5()
    {
        return $this->code5;
    }

    /**
     * Set code6
     *
     * @param string $code6
     *
     * @return Jugada
     */
    public function setCode6($code6)
    {
        $this->code6 = $code6;

        return $this;
    }

    /**
     * Get code6
     *
     * @return string
     */
    public function getCode6()
    {
        return $this->code6;
    }
}
