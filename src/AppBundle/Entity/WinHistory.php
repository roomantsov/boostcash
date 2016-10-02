<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * History
 *
 * @ORM\Table(name="winhistory")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WinHistoryRepository")
 */
class WinHistory
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
     * @ORM\Column(name="winnerid", type="integer")
     */
    private $winnerid;

    /**
     * @var int
     *
     * @ORM\Column(name="caseid", type="integer")
     */
    private $caseid;

    /**
     * @var int
     *
     * @ORM\Column(name="itemid", type="integer")
     */
    private $itemid;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var bool
     *
     * @ORM\Column(name="isshowed", type="boolean")
     */
    private $isshowed;


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
     * Set winnerid
     *
     * @param integer $winnerid
     *
     * @return History
     */
    public function setWinnerid($winnerid)
    {
        $this->winnerid = $winnerid;

        return $this;
    }

    /**
     * Get winnerid
     *
     * @return int
     */
    public function getWinnerid()
    {
        return $this->winnerid;
    }

    /**
     * Set caseid
     *
     * @param integer $caseid
     *
     * @return History
     */
    public function setCaseid($caseid)
    {
        $this->caseid = $caseid;

        return $this;
    }

    /**
     * Get caseid
     *
     * @return int
     */
    public function getCaseid()
    {
        return $this->caseid;
    }

    /**
     * Set itemid
     *
     * @param integer $itemid
     *
     * @return History
     */
    public function setItemid($itemid)
    {
        $this->itemid = $itemid;

        return $this;
    }

    /**
     * Get itemid
     *
     * @return int
     */
    public function getItemid()
    {
        return $this->itemid;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return History
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set isshowed
     *
     * @param boolean $isshowed
     *
     * @return User
     */
    public function setIsshowed($isshowed)
    {
        $this->isshowed = $isshowed;

        return $this;
    }

    /**
     * Get isshowed
     *
     * @return bool
     */
    public function getIsshowed()
    {
        return $this->isshowed;
    }
}

