<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="text")
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="bdate", type="text")
     */
    private $bdate;

    /**
     * @var string
     *
     * @ORM\Column(name="vkid", type="string", length=255, unique=true)
     */
    private $vkid;

    /**
     * @var int
     *
     * @ORM\Column(name="balance", type="integer")
     */
    private $balance;

    /**
     * @var string
     *
     * @ORM\Column(name="refcode", type="string", length=255)
     */
    private $refcode;

    /**
     * @var bool
     *
     * @ORM\Column(name="ischeat", type="boolean")
     */
    private $ischeat;

    /**
     * @var bool
     *
     * @ORM\Column(name="isrefered", type="boolean")
     */
    private $isrefered;

    /**
     * @var int
     *
     * @ORM\Column(name="percentage", type="integer")
     */
    private $percentage;


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
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set bdate
     *
     * @param string $bdate
     *
     * @return User
     */
    public function setBdate($bdate)
    {
        $this->bdate = $bdate;

        return $this;
    }

    /**
     * Get bdate
     *
     * @return string
     */
    public function getBdate()
    {
        return $this->bdate;
    }

    /**
     * Set vkid
     *
     * @param string $vkid
     *
     * @return User
     */
    public function setVkid($vkid)
    {
        $this->vkid = $vkid;

        return $this;
    }

    /**
     * Get vkid
     *
     * @return string
     */
    public function getVkid()
    {
        return $this->vkid;
    }

    /**
     * Set balance
     *
     * @param integer $balance
     *
     * @return User
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return int
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set refcode
     *
     * @param string $refcode
     *
     * @return User
     */
    public function setRefcode($refcode)
    {
        $this->refcode = $refcode;

        return $this;
    }

    /**
     * Get refcode
     *
     * @return string
     */
    public function getRefcode()
    {
        return $this->refcode;
    }

    /**
     * Set ischeat
     *
     * @param boolean $ischeat
     *
     * @return User
     */
    public function setIscheat($ischeat)
    {
        $this->ischeat = $ischeat;

        return $this;
    }

    /**
     * Get ischeat
     *
     * @return bool
     */
    public function getIscheat()
    {
        return $this->ischeat;
    }

    /**
     * Set isrefered
     *
     * @param boolean $isrefered
     *
     * @return User
     */
    public function setIsrefered($isrefered)
    {
        $this->isrefered = $isrefered;

        return $this;
    }

    /**
     * Get isrefered
     *
     * @return bool
     */
    public function getIsrefered()
    {
        return $this->isrefered;
    }

    /**
     * Set percentage
     *
     * @param integer $percentage
     *
     * @return User
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
}

