<?php
/**
 * Created by PhpStorm.
 * User: Etienne
 * Date: 25/10/2016
 * Time: 22:57
 */
namespace EcommerceBundle\Twig\Extension;

class TvaExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('tva', array($this, 'calculTva')));
    }
    public function calculTva($prixHT, $tva)
    {
       return round($prixHT / $tva,2);
    }
    public function getName()
    {
        return 'tva_extension';
    }
}