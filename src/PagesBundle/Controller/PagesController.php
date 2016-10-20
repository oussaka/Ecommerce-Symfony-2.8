<?php

namespace PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PagesController extends Controller
{
    /**
     * @Route("/page/{id}")
     */
    public function indexAction($id)
    {
        if ($id == 1)
        {
            $titre = 'CGV';
        }else
        {
            $titre = 'Mentions légales';
        }
        return $this->render('PagesBundle:Default:index.html.twig', array('titre' => $titre));
    }
}
