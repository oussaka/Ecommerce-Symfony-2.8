<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EcommerceBundle\Entity\Produits;
use Symfony\Component\HttpFoundation\Request;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;

class TestController extends Controller
{
    /**
     * @Route("/testAddBdd", name="testAddBdd")
     */
    public function ajoutAction()
    {
        // Appel du gestionnaire de BDD
        $em = $this->getDoctrine()->getManager();

        /**
         *
        // Appel de la classe Produit
        $produit = new Produits();

        // Création de tous les champs
        $produit->setCategorie('Legume');
        $produit->setDescription('La tomate c\'est bon');
        $produit->setDisponible('1');
        $produit->setImage('http://www.coloori.com/wp-content/uploads/2016/02/tomatedessin.jpg');
        $produit->setNom('Tomate');
        $produit->setPrix('0.99');
        $produit->setTva('19.6');


        $em->persist($produit);
        // Ajout dans la BDD
        $em->flush();
         *
        **/

        // Récupération de tous les produits de la BDD
        $produits = $em->getRepository('EcommerceBundle:Produits')->findAll();

        // Affichage sur la page
        return $this->render('EcommerceBundle:Front/Test:testAddBdd.html.twig', array('titre' => 'Les produits', 'produits' => $produits));
    }

    /**
     * @Route("/testFormulaire", name="testFormulaire")
     */
    public function testFormulaireAction(Request $request)
    {
        $form = $this->createFormBuilder()
                    ->add('Email', 'email')
                    ->add('Nom','text', array('required' => false))
                    ->add('Genre', 'choice', array('required' => false, 'choices' => array('0' => 'Homme',
                        '1' => 'Femme',
                        '2' => 'Autre')))
                    ->add('Cheveux', 'choice', array('required' => false, 'choices' => array('0' => 'Brun',
                        '1' => 'Blond',
                        '2' => 'Chatain'), 'expanded' => true))
                    ->add('Message', 'textarea', array('required' => false))
                    ->add('Date', 'date', array('required' => false))
                    ->add('Utilisateurs', 'entity', array('class' => 'UtilisateursBundle\Entity\Utilisateurs'), array('required' => false))
                    ->add('Pays', 'country', array('preferred_choices' => array('FR')), array('required' => false))
                    ->add('Recaptcha', EWZRecaptchaType::class, array('required' => false))
                    ->add('Envoyer', 'submit', array('attr' => array('class' => 'btn btn-block btn-info')), array('required' => false))
                    ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            echo $form['Email']->getData();
        }


        return $this->render('@Ecommerce/Front/Test/testFormulaire.html.twig', array('titre' => 'Contact','form' => $form->createView()));
    }
}
