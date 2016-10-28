<?php
/**
 * Created by PhpStorm.
 * User: Etienne
 * Date: 28/10/2016
 * Time: 14:45
 */
namespace EcommerceBundle\Twig\Extension;

class montantTvaExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('montantTva', array($this, 'montantTva')));
    }
    public function montantTva($prixHT, $tva)
    {
        return round((($prixHT / $tva) - $prixHT),2);
    }
    public function getName()
    {
        return 'montant_tva_extension';
    }
}