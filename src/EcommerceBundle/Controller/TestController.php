<?php

namespace EcommerceBundle\Controller;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{
    /**
     * @Route("/testFormulaire", name="testFormulaire")
     */
    public function testFormulaireAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('Email', 'email')
            ->add('Nom', 'text', array('required' => false))
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

        if ($form->isSubmitted() && $form->isValid()) {
            echo $form['Email']->getData();
        }


        return $this->render('@Ecommerce/Front/Test/testFormulaire.html.twig', array('titre' => 'Contact', 'form' => $form->createView()));
    }
}
