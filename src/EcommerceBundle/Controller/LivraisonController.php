<?php
/**
 * Created by PhpStorm.
 * User: Etienne
 * Date: 16/10/2016
 * Time: 11:10
 */

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\UtilisateursAdresses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EcommerceBundle\Form\UtilisateursAdressesType;
use Symfony\Component\HttpFoundation\Request;

class LivraisonController extends Controller
{
    /**
     * @Route("/livraison", name="livraison")
     */
    public function livraisonAction(Request $request)
    {
        $utilisateur = $this->getUser();
        $entity = new UtilisateursAdresses();
        $form = $this->createForm(new UtilisateursAdressesType(), $entity);

        if ($this->get('request')->getMethod() == 'POST')
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $entity->setUtilisateur($utilisateur);
                $em->persist($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Votre adresse a bien été ajoutée');

                return $this->redirect($this->generateUrl('livraison'));
            }
        }

        return $this->render('EcommerceBundle:Front/Livraison:index.html.twig', array('titre' => 'Livraison','utilisateur' => $utilisateur ,'form' => $form->createView()));
    }

    /**
     * @param $id
     * @return string
     * @Route("livraisonAdresseSuppression/{id}", name="livraisonAdresseSuppression")
     */
    public function adresseSuppressionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($id);

        if ($this->getUser() != $entity->getUtilisateur() || !$entity)
        {
            return $this->generateUrl('livraison');
        }
        $em->remove($entity);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Votre adresse a bien été supprimée');
        return $this->redirect ($this->generateUrl ('livraison'));
    }

    /**
     * @Route("/validation", name="validation")
     */
    public function validationAction()
    {
        return $this->render('EcommerceBundle:Front/Livraison:validation.html.twig', array('titre' => 'Validation'));
    }

}