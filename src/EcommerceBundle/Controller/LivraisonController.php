<?php
/**
 * Created by PhpStorm.
 * User: Etienne
 * Date: 16/10/2016
 * Time: 11:10
 */

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LivraisonController extends Controller
{
    /**
     * @Route("/livraison", name="livraison")
     */
    public function livraisonAction()
    {
        return $this->render('EcommerceBundle:Front/Livraison:index.html.twig', array('titre' => 'Livraison'));
    }/**
     * @Route("/validation", name="validation")
     */
    public function validationAction()
    {
        return $this->render('EcommerceBundle:Front/Livraison:validation.html.twig', array('titre' => 'Validation'));
    }

}