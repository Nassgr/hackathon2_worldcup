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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Country", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $countryid;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\Player", mappedBy="teamid")
    * @ORM\JoinColumn(nullable=false)
    */
    private $players;



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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add player
     *
     * @param \AppBundle\Entity\Player $player
     *
     * @return team
     */
    public function addPlayer(\AppBundle\Entity\Player $player)
    {
        $this->players[] = $player;

        return $this;
    }

    /**
     * Remove player
     *
     * @param \AppBundle\Entity\Player $player
     */
    public function removePlayer(\AppBundle\Entity\Player $player)
    {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    public function __toString()

    {

        return "$this->id";


    }



    /**
     * Set countryid
     *
     * @param \AppBundle\Entity\Country $countryid
     *
     * @return team
     */
    public function setCountryid(\AppBundle\Entity\Country $countryid)
    {
        $this->countryid = $countryid;

        return $this;
    }

    /**
     * Get countryid
     *
     * @return \AppBundle\Entity\Country
     */
    public function getCountryid()
    {
        return $this->countryid;
    }
}
