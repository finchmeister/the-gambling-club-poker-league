<?php


namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('percent', array($this, 'percentFilter')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '£'.$price;

        return $price;
    }

    public function percentFilter($number, $decimals = 0)
    {
        $price = number_format($number * 100, $decimals);
        $price = $price.'%';

        return $price;
    }
}