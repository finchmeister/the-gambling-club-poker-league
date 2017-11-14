<?php


namespace AppBundle\Helper;


class ArrayHelper
{
    /**
     * @param array $array
     * @return float|null
     */
    public static function getArrayMedian(array $array): ?float
    {
        if (count($array) === 0) {
            return null;
        }
        $array = array_values($array);
        asort($array);
        $middleIndex = (int)floor((count($array) - 1)/2);
        if (count($array)%2 === 0) {
            $lowIndex = $middleIndex;
            $highIndex = $lowIndex+1;
            $median = ($array[$lowIndex] + $array[$highIndex])/2;
        } else {
            $median = $array[$middleIndex];
        }
        return $median;
    }

    public static function getArrayMode(array $array)
    {
        if (count($array) === 0) {
            return null;
        }
        $c = array_count_values($array);
        $commonValues = array_keys($c, max($c));
        if (count($commonValues) > 1) {
            return null;
        }
        return $commonValues[0];
    }
}