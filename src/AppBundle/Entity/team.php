<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\teamRepository")
 */
class team
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
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="NBjoueur", type="integer")
     */
    private $nBjoueur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="temps", type="time", nullable=true)
     */
    private $temps;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return team
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nBjoueur
     *
     * @param integer $nBjoueur
     *
     * @return team
     */
    public function setNBjoueur($nBjoueur)
    {
        $this->nBjoueur = $nBjoueur;

        return $this;
    }

    /**
     * Get nBjoueur
     *
     * @return int
     */
    public function getNBjoueur()
    {
        return $this->nBjoueur;
    }

    /**
     * Set temps
     *
     * @param \DateTime $temps
     *
     * @return team
     */
    public function setTemps($temps)
    {
        $this->temps = $temps;

        return $this;
    }

    /**
     * Get temps
     *
     * @return \DateTime
     */
    public function getTemps()
    {
        return $this->temps;
    }
}

