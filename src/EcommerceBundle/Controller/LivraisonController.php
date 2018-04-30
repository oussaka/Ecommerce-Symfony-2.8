<?php
/**
 * Created by PhpStorm.
 * User: Etienne
 * Date: 16/10/2016
 * Time: 11:10
 */

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\UtilisateursAdresses;
use EcommerceBundle\Form\UtilisateursAdressesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

        if ($this->get('request')->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity->setUtilisateur($utilisateur);
                $em->persist($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Votre adresse a bien été ajoutée');

                return $this->redirect($this->generateUrl('livraison'));
            }
        }

        return $this->render('EcommerceBundle:Front/Livraison:index.html.twig', array('titre' => 'Livraison', 'utilisateur' => $utilisateur, 'form' => $form->createView()));
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

        if ($this->getUser() != $entity->getUtilisateur() || !$entity) {
            return $this->generateUrl('livraison');
        }
        $em->remove($entity);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Votre adresse a bien été supprimée');
        return $this->redirect($this->generateUrl('livraison'));
    }

    public function setLivraisonOnSession(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('adresse')) $session->set('adresse', array());
        $adresse = $session->get('adresse');

        if ($request->request->get('livraison') != null && $request->request->get('facturation')) {
            $adresse['livraison'] = $request->request->get('livraison');
            $adresse['facturation'] = $request->request->get('facturation');
        } else {
            return $this->redirect($this->generateUrl('validation'));
        }
        $session->set('adresse', $adresse);
        return $this->redirect($this->generateUrl('validation'));
    }

    /**
     * @Route("/validation", name="validation")
     */
    public function validationAction(Request $request)
    {
        if ($this->get('request')->getMethod() == 'POST') {
            $this->setLivraisonOnSession($request);
        }

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $adresse = $session->get('adresse');

        $produits = $em->getRepository('EcommerceBundle:Produits')->findArray(array_keys($session->get('panier')));
        $livraison = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($adresse['livraison']);
        $facturation = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($adresse['facturation']);

        return $this->render('EcommerceBundle:Front/Livraison:validation.html.twig', array('titre' => 'Validation',
            'produits' => $produits,
            'livraison' => $livraison,
            'facturation' => $facturation,
            'panier' => $session->get('panier')));
    }

}