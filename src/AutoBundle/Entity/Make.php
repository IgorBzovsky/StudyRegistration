<?php

namespace AutoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Make
 *
 * @UniqueEntity("name")
 * @ORM\Table(name="make")
 * @ORM\Entity(repositoryClass="AutoBundle\Repository\MakeRepository")
 */
class Make
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
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var ArrayCollection|Model
     *
     * @ORM\OneToMany(targetEntity="Model", mappedBy="make")
     */
    private $models;

    /**
     * @var ArrayCollection|Car
     *
     * @ORM\OneToMany(targetEntity="Car", mappedBy="make")
     */
    private $cars;

    public function __construct() {
        $this->models = new ArrayCollection();
        $this->cars = new ArrayCollection();
    }

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
     * @return Make
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

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Add model
     *
     * @param \AutoBundle\Entity\Model $model
     *
     * @return Make
     */
    public function addModel(\AutoBundle\Entity\Model $model)
    {
        $this->models[] = $model;

        return $this;
    }

    /**
     * Remove model
     *
     * @param \AutoBundle\Entity\Model $model
     */
    public function removeModel(\AutoBundle\Entity\Model $model)
    {
        $this->models->removeElement($model);
    }

    /**
     * Get models
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * Add car
     *
     * @param \AutoBundle\Entity\Car $car
     *
     * @return Make
     */
    public function addCar(\AutoBundle\Entity\Car $car)
    {
        $this->cars[] = $car;

        return $this;
    }

    /**
     * Remove car
     *
     * @param \AutoBundle\Entity\Car $car
     */
    public function removeCar(\AutoBundle\Entity\Car $car)
    {
        $this->cars->removeElement($car);
    }

    /**
     * Get cars
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCars()
    {
        return $this->cars;
    }
}
