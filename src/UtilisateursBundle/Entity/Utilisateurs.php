<?php

namespace UtilisateursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateurs")
 */
class Utilisateurs extends BaseUser
{
    public function __construct()
    {
        parent::__construct();
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->adresses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", nullable=true)
     */
    protected $facebook_id;

    /**
     * @Recaptcha\IsTrue
     */
    public $recaptcha;

    /**
     * @ORM\OneToMany(targetEntity="EcommerceBundle\Entity\Commandes", mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $commandes;

    /**
     * @ORM\OneToMany(targetEntity="EcommerceBundle\Entity\UtilisateursAdresses", mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresses;

    /**
     * Add commande
     *
     * @param \EcommerceBundle\Entity\Commandes $commande
     *
     * @return Utilisateurs
     */
    public function addCommande(\EcommerceBundle\Entity\Commandes $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \EcommerceBundle\Entity\Commandes $commande
     */
    public function removeCommande(\EcommerceBundle\Entity\Commandes $commande)
    {
        $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Add adresses
     *
     * @param \EcommerceBundle\Entity\UtilisateursAdresses $adress
     *
     * @return Utilisateurs
     */
    public function addAdress(\EcommerceBundle\Entity\UtilisateursAdresses $adresses)
    {
        $this->adresses[] = $adresses;

        return $this;
    }

    /**
     * Remove adresses
     *
     * @param \EcommerceBundle\Entity\UtilisateursAdresses $adresses
     */
    public function removeAdress(\EcommerceBundle\Entity\UtilisateursAdresses $adresses)
    {
        $this->adresses->removeElement($adresses);
    }

    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return Utilisateurs
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }
}
