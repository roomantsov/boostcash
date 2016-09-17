<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Referal
 *
 * @ORM\Table(name="referals")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReferalRepository")
 */
class Referal
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
     * @ORM\Column(name="visitor", type="integer")
     */
    private $visitor;

    /**
     * @var int
     *
     * @ORM\Column(name="inviter", type="integer")
     */
    private $inviter;

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
     * Set visitor
     *
     * @param integer $visitor
     *
     * @return Referal
     */
    public function setVisitor($visitor)
    {
        $this->visitor = $visitor;

        return $this;
    }

    /**
     * Get visitor
     *
     * @return int
     */
    public function getVisitor()
    {
        return $this->visitor;
    }

    /**
     * Set inviter
     *
     * @param integer $inviter
     *
     * @return Referal
     */
    public function setInviter($inviter)
    {
        $this->inviter = $inviter;

        return $this;
    }

    /**
     * Get inviter
     *
     * @return int
     */
    public function getInviter()
    {
        return $this->inviter;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Referal
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

