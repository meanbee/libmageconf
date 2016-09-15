<?php

namespace Meanbee\LibMageConfTest\Util;

use Meanbee\LibMageConf\Util\ArrayQuery;
use PHPUnit\Framework\TestCase;

class ArrayQueryTest extends TestCase
{
    /**
     * @test
     * @dataProvider providerTestValues
     */
    public function testGetValue($path, $expectedValue)
    {
        $testArray = [
            'a' => '123',
            'b' => '456',
            'c' => [
                'd' => '789'
            ],
            'e' => [
                'f' => [
                    'g' => [
                        'h' => 'hello'
                    ],
                    'i' => 'world'
                ]
            ]
        ];

        $subject = new ArrayQuery($testArray);

        $this->assertEquals($expectedValue, $subject->query($path));
    }

    public function providerTestValues()
    {
        $pairs = [
            'a'       => '123',
            'b'       => '456',
            'c'       => [
                'd' => '789'
            ],
            'c/d'     => '789',
            'e/f/g/h' => 'hello',
            'e/f/i'   => 'world',
            'z'       => null
        ];

        $formatted = [];

        foreach ($pairs as $key => $value) {
            $formatted[] = [$key, $value];
        }

        return $formatted;
    }
}