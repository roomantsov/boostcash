<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cheat
 *
 * @ORM\Table(name="cheat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CheatRepository")
 */
class Cheat
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
     * @ORM\Column(name="itemrange", type="string", length=255)
     */
    private $itemrange;

    /**
     * @var bool
     *
     * @ORM\Column(name="isused", type="boolean")
     */
    private $isused;


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
     * Set itemrange
     *
     * @param string $itemrange
     *
     * @return Cheat
     */
    public function setItemrange($itemrange)
    {
        $this->itemrange = $itemrange;

        return $this;
    }

    /**
     * Get itemrange
     *
     * @return string
     */
    public function getItemrange()
    {
        return $this->itemrange;
    }

    /**
     * Set isused
     *
     * @param boolean $isused
     *
     * @return Cheat
     */
    public function setIsused($isused)
    {
        $this->isused = $isused;

        return $this;
    }

    /**
     * Get isused
     *
     * @return bool
     */
    public function getIsused()
    {
        return $this->isused;
    }
}

