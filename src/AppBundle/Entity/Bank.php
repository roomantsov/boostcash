<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bank
 *
 * @ORM\Table(name="bank")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BankRepository")
 */
class Bank
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
     * @var string
     *
     * @ORM\Column(name="caserange", type="string", length=255)
     */
    private $caserange;

    /**
     * @var int
     *
     * @ORM\Column(name="min", type="integer")
     */
    private $min;

    /**
     * @var int
     *
     * @ORM\Column(name="max", type="integer")
     */
    private $max;

    /**
     * @var int
     *
     * @ORM\Column(name="random", type="integer")
     */
    private $random;

    /**
     * @var int
     *
     * @ORM\Column(name="collected", type="integer")
     */
    private $collected;

    /**
     * @var int
     *
     * @ORM\Column(name="wintime", type="integer")
     */
    private $wintime;


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
     * Set caserange
     *
     * @param string $caserange
     *
     * @return Bank
     */
    public function setCaserange($caserange)
    {
        $this->caserange = $caserange;

        return $this;
    }

    /**
     * Get caserange
     *
     * @return string
     */
    public function getCaserange()
    {
        return $this->caserange;
    }

    /**
     * Set min
     *
     * @param integer $min
     *
     * @return Bank
     */
    public function setMin($min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Get min
     *
     * @return int
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set max
     *
     * @param integer $max
     *
     * @return Bank
     */
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Get max
     *
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Set random
     *
     * @param integer $random
     *
     * @return Bank
     */
    public function setRandom($random)
    {
        $this->random = $random;

        return $this;
    }

    /**
     * Get random
     *
     * @return int
     */
    public function getRandom()
    {
        return $this->random;
    }

    /**
     * Set collected
     *
     * @param integer $collected
     *
     * @return Bank
     */
    public function setCollected($collected)
    {
        $this->collected = $collected;

        return $this;
    }

    /**
     * Get collected
     *
     * @return int
     */
    public function getCollected()
    {
        return $this->collected;
    }

    /**
     * Set wintime
     *
     * @param integer $wintime
     *
     * @return Bank
     */
    public function setWintime($wintime)
    {
        $this->wintime = $wintime;

        return $this;
    }

    /**
     * Get wintime
     *
     * @return int
     */
    public function getWintime()
    {
        return $this->wintime;
    }
}

