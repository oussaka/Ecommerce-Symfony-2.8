<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PanierController extends Controller
{
    /**
     * @Route("/panier", name="panier")
     */
    public function panierAction()
    {
        return $this->render('EcommerceBundle:Front/Panier:index.html.twig', array('titre' => 'Panier'));
    }
}
