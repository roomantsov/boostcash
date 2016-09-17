<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OutputRequest
 *
 * @ORM\Table(name="output_request")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OutputRequestRepository")
 */
class OutputRequest
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
     * @ORM\Column(name="walletnumber", type="string", length=255)
     */
    private $walletnumber;

    /**
     * @var bool
     *
     * @ORM\Column(name="isdone", type="boolean")
     */
    private $isdone;

    /**
     * @var string
     *
     * @ORM\Column(name="wallettype", type="string", length=255)
     */
    private $wallettype;

    /**
     * @var int
     *
     * @ORM\Column(name="userid", type="integer")
     */
    private $userid;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;


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
     * Set walletnumber
     *
     * @param string $walletnumber
     *
     * @return OutputRequest
     */
    public function setWalletnumber($walletnumber)
    {
        $this->walletnumber = $walletnumber;

        return $this;
    }

    /**
     * Get walletnumber
     *
     * @return string
     */
    public function getWalletnumber()
    {
        return $this->walletnumber;
    }

    /**
     * Set isdone
     *
     * @param boolean $isdone
     *
     * @return OutputRequest
     */
    public function setIsdone($isdone)
    {
        $this->isdone = $isdone;

        return $this;
    }

    /**
     * Get isdone
     *
     * @return bool
     */
    public function getIsdone()
    {
        return $this->isdone;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return OutputRequest
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     *
     * @return OutputRequest
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return OutputRequest
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return OutputRequest
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }
}

