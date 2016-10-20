<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\EcommerceBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EcommerceBundle\Entity\Produits;

class TestController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function ajoutAction()
    {
        // Appel du gestionnaire de BDD
        $em = $this->getDoctrine()->getManager();

        /**
         *
        // Appel de la classe Produit
        $produit = new Produits();

        // Création de tous les champs
        $produit->setCategorie('Legume');
        $produit->setDescription('La tomate c\'est bon');
        $produit->setDisponible('1');
        $produit->setImage('http://www.coloori.com/wp-content/uploads/2016/02/tomatedessin.jpg');
        $produit->setNom('Tomate');
        $produit->setPrix('0.99');
        $produit->setTva('19.6');


        $em->persist($produit);
        // Ajout dans la BDD
        $em->flush();
         *
        **/

        // Récupération de tous les produits de la BDD
        $produits = $em->getRepository('EcommerceBundle:Produits')->findAll();

        // Affichage sur la page
        return $this->render('EcommerceBundle:Front/Test:index.html.twig', array('titre' => 'Les produits', 'produits' => $produits));
    }
}
