<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRepository")
 */
class Item
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
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="caseid", type="integer")
     */
    private $caseid;

    /**
     * @var string
     *
     * @ORM\Column(name="itemrange", type="string", length=255)
     */
    private $itemrange;


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
     * Set value
     *
     * @param integer $value
     *
     * @return Item
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
     * Set caseid
     *
     * @param integer $caseid
     *
     * @return Item
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
     * Set itemrange
     *
     * @param string $itemrange
     *
     * @return Item
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
}

