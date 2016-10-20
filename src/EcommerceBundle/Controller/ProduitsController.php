<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProduitsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function produitsAction()
    {
        return $this->render('EcommerceBundle:Front/Produits:index.html.twig', array('titre' => 'Produits'));
    }
    /**
     * @Route("/produit", name="produit")
     */
    public function presentationProduitAction()
    {
        return $this->render('EcommerceBundle:Front/Produits:details.html.twig', array('titre' => 'Produit'));
    }
}
