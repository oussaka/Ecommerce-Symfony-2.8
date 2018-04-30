<?php

namespace EcommerceBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoriesController extends Controller
{
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('EcommerceBundle:Categories')->findAll();

        return $this->render('@Ecommerce/Front/Default/categories/modulesUsed/menu.html.twig', array('categories' => $categories));
    }


    /**
     * @Route("/categorie/{id}", name="categorie")
     */
    public function categoriesAction($id, Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        $findProduits = $em->getRepository('EcommerceBundle:Produits')->byCategorie($id);

        if (!$findProduits) {
            throw $this->createNotFoundException('La page n\'existe pas');
        }

        if ($session->has('panier')) {
            $panier = $session->get('panier');
        } else {
            $panier = false;
        }

        $produits = $this->get('knp_paginator')->paginate($findProduits, $request->query->get('page', 1)/*page number*/, 4/*limit per page*/);

        return $this->render('EcommerceBundle:Front/Produits:index.html.twig', array('titre' => 'Produits', 'produits' => $produits, 'panier' => $panier));
    }
}
