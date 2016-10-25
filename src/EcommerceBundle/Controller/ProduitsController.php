<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProduitsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function produitsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('EcommerceBundle:Produits')->findBy(array('disponible' => 1));
        return $this->render('EcommerceBundle:Front/Produits:index.html.twig', array('titre' => 'Produits', 'produits' => $produits));
    }

    /**
     * @Route("/produit/{id}", name="produit")
     */
    public function presentationProduitAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('EcommerceBundle:Produits')->find($id);

        if (!$produit){throw $this->createNotFoundException('La page n\'existe pas');}

        return $this->render('EcommerceBundle:Front/Produits:details.html.twig', array('titre' => 'Produit', 'produit' => $produit));
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
