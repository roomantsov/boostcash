<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Referalhistory
 *
 * @ORM\Table(name="referalhistory")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReferalhistoryRepository")
 */
class Referalhistory
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
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="visitorid", type="integer")
     */
    private $visitorid;

    /**
     * @var int
     *
     * @ORM\Column(name="inviterid", type="integer")
     */
    private $inviterid;

    /**
     * @var int
     *
     * @ORM\Column(name="percentamount", type="integer")
     */
    private $percentamount;

    /**
     * @var int
     *
     * @ORM\Column(name="percentage", type="integer")
     */
    private $percentage;

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
     * Set amount
     *
     * @param integer $amount
     *
     * @return Referalhistory
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
     * Set visitorid
     *
     * @param integer $visitorid
     *
     * @return Referalhistory
     */
    public function setVisitorid($visitorid)
    {
        $this->visitorid = $visitorid;

        return $this;
    }

    /**
     * Get visitorid
     *
     * @return int
     */
    public function getVisitorid()
    {
        return $this->visitorid;
    }

    /**
     * Set inviterid
     *
     * @param integer $inviterid
     *
     * @return Referalhistory
     */
    public function setInviterid($inviterid)
    {
        $this->inviterid = $inviterid;

        return $this;
    }

    /**
     * Get inviterid
     *
     * @return int
     */
    public function getInviterid()
    {
        return $this->inviterid;
    }

    /**
     * Set percentamount
     *
     * @param integer $percentamount
     *
     * @return Referalhistory
     */
    public function setPercentamount($percentamount)
    {
        $this->percentamount = $percentamount;

        return $this;
    }

    /**
     * Get percentamount
     *
     * @return int
     */
    public function getPercentamount()
    {
        return $this->percentamount;
    }

    /**
     * Set percentage
     *
     * @param integer $percentage
     *
     * @return Referalhistory
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return int
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Referalhistory
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

