<?php


namespace Tests\AppBundle\Helper;

use AppBundle\Helper\ArrayHelper;
use PHPUnit\Framework\TestCase;

class ArrayHelperTest extends TestCase
{

    /**
     * @dataProvider arrayMedianProvider
     */
    public function testArrayMedian($array, $expected)
    {
        $this->assertEquals($expected, ArrayHelper::getArrayMedian($array));
    }

    public function arrayMedianProvider()
    {
        return [
            [[], null],
            [[1,], 1],
            [[1, 2, 3,], 2],
            [[3, 2, 1,], 2],
            [[3, 2, 3, 1,], 2.5],
            [[3, 2, 5, 1,], 2.5],
            [[3, 2, 3, 1, 5,], 3],
            [[0, 2, 3, 1,], 1.5],
        ];
    }

    /**
     * @dataProvider arrayModeProvider
     */
    public function testArrayMode($array, $expected)
    {
        $this->assertEquals($expected, ArrayHelper::getArrayMode($array));
    }

    public function arrayModeProvider()
    {
        return [
            [[], null],
            [[1, 2, 3, 4,], null],
            [[1, 2, 3, 2,], 2],
            [[1, 2, 3, 2, 1,], null],
            [[1], 1],
        ];
    }
}