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
        $this->assertEquals($expected, ArrayHelper::findArrayMedian($array));
    }

    public function arrayMedianProvider()
    {
        return [
            [[], null],
            [[1,], 1],
            [[1, 2, 3,], 2],
            [[3, 2, 1,], 2],
            [[3, 2, 3, 1,], 2.5],
            [[3, 2, 5, 1,], 3.5],
            [[3, 2, 3, 1, 5,], 3],
            [[0, 2, 3, 1,], 2.5],
        ];
    }
}