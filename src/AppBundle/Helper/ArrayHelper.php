<?php


namespace AppBundle\Helper;


class ArrayHelper
{
    public static function findArrayMedian(array $array)
    {
        $array = array_values($array);
        asort($array);
        $middleIndex = (int)floor((count($array))/2);
        if (count($array)%2 === 0) {
            $lowIndex = $middleIndex;
            $highIndex = $lowIndex+1;
            $median = ($array[$lowIndex] + $array[$highIndex])/2;
        } else {
            $median = $array[$middleIndex];
        }
        return $median;
    }
}