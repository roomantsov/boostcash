<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visitor
 *
 * @ORM\Table(name="visitors")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VisitorRepository")
 */
class Visitor
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
     * @ORM\Column(name="ip", type="text")
     */
    private $ip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastseen", type="datetime")
     */
    private $lastseen;


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
     * Set ip
     *
     * @param string $ip
     *
     * @return Visitor
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set lastseen
     *
     * @param \DateTime $lastseen
     *
     * @return Visitor
     */
    public function setLastseen($lastseen)
    {
        $this->lastseen = $lastseen;

        return $this;
    }

    /**
     * Get lastseen
     *
     * @return \DateTime
     */
    public function getLastseen()
    {
        return $this->lastseen;
    }
}

