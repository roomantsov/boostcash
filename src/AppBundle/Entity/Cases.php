<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Case
 *
 * @ORM\Table(name="cases")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CasesRepository")
 */
class Cases
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="caserange", type="string", length=255)
     */
    private $caserange;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;


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
     * @return Cases
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
     * Set caserange
     *
     * @param string $caserange
     *
     * @return Cases
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
     * Set image
     *
     * @param string $image
     *
     * @return Cases
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Cases
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }
}

