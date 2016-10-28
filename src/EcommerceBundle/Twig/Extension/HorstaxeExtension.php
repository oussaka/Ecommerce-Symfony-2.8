<?php
/**
 * Created by PhpStorm.
 * User: Etienne
 * Date: 27/10/2016
 * Time: 22:20
 */
namespace EcommerceBundle\Twig\Extension;

class HorstaxeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('horstaxe', array($this, 'calculHT')));
    }
    public function calculHT($prixTTC, $tva)
    {
        return round($prixTTC * $tva,2);
    }
    public function getName()
    {
        return 'horstaxe_extension';
    }
}