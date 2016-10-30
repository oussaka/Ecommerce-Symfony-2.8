<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProduitsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function produitAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();

        $findProduits = $em->getRepository('EcommerceBundle:Produits')->findBy(array('disponible' => 1));
        if ($session->has('panier'))
        {
            $panier = $session->get('panier');
        }else
        {
            $panier = false;
        }

        $produits  = $this->get('knp_paginator')->paginate($findProduits,$request->query->get('page', 1)/*page number*/,4/*limit per page*/);

        return $this->render('EcommerceBundle:Front/Produits:index.html.twig', array('titre' => 'Produits', 'produits' => $produits, 'panier' => $panier));
    }

    /**
     * @Route("/produit/{id}", name="produit")
     */
    public function presentationProduitAction($id, Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('EcommerceBundle:Produits')->find($id);

        if (!$produit)
        {
            throw $this->createNotFoundException('La page n\'existe pas');
        }

        if ($session->has('panier'))
        {
            $panier = $session->get('panier');
        }else
        {
            $panier = false;
        }

        return $this->render('EcommerceBundle:Front/Produits:details.html.twig', array('titre' => 'Produit', 'produit' => $produit, 'panier' => $panier));
    }

    public function rechercheAction()
    {
        $form = $this->createForm(new RechercheType());
        return $this->render('@Utilisateurs/Default/Recherche/index.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/recherche", name="recherche")
     */
    public function rechercheTraitementAction()
    {
        $form = $this->createForm(new RechercheType());
        if ($this->get('request')->getMethod() == 'POST')
        {
            $form->bind($this->get('request'));
            $chaine = $form['recherche']->getData();
            $em = $this->getDoctrine()->getManager();
            $produit = $em->getRepository('EcommerceBundle:Produits')->recherche($chaine);
        }else{
            throw $this->createNotFoundException('La page n\'existe pas');
        }
        return $this->render('EcommerceBundle:Front/Produits:index.html.twig', array('produits' => $produit));
    }
}
