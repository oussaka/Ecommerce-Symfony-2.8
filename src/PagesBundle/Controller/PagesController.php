<?php

namespace PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PagesController extends Controller
{
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('PagesBundle:Pages')->findAll();

        return $this->render('PagesBundle:Default:pages/modulesUsed/menu.html.twig', array('pages' => $pages));
    }

    /**
     * @Route("/page/{id}")
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('PagesBundle:Pages')->find($id);

        if (!$page) throw $this->createNotFoundException('La page n\'existe pas');

        return $this->render('PagesBundle:Default:index.html.twig', array('page' => $page));
    }
}
