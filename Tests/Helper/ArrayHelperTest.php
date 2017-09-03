<?php

namespace KaneMenicou\FastControllerBundle\Tests\Helper;

use KaneMenicou\FastControllerBundle\Helper\ArrayHelper;

class ArrayHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider arrayToFlatArray
     *
     * @param $array
     * @param $expectedArray
     */
    public function itWillFlattenAnArray($array, $expectedArray)
    {
        $this->assertSame($expectedArray, ArrayHelper::flattenArray($array));
    }

    /**
     * @return array
     */
    public function arrayToFlatArray(): array
    {
        return [
            'Already flat' => [
                'array' => [
                    'key' => 'value',
                    'anotherKey' => 'anotherValue'
                ],
                'expectedArray' => [
                    'key' => 'value',
                    'anotherKey' => 'anotherValue'
                ]
            ],
            'No Key' => [
                'array' => [
                    'value',
                    'anotherKey' => 'anotherValue'
                ],
                'expectedArray' => [
                    'value',
                    'anotherKey' => 'anotherValue'
                ]
            ],
            'Two dimensional' => [
                'array' => [
                    'key' => 'value',
                    'anotherKey' => 'anotherValue',
                    'anotherArray' => [
                        'key' => 'value',
                    ]
                ],
                'expectedArray' => [
                    'key' => 'value',
                    'anotherKey' => 'anotherValue',
                    'anotherArray.key' => 'value'
                ]
            ],
            'Multi dimensional' => [
                'array' => [
                    'key' => 'value',
                    'anotherKey' => 'anotherValue',
                    'anotherArray' => [
                        'key' => 'value',
                        'yetAnother' => [
                            'key' => 'yetAnotherValue',
                        ]
                    ]
                ],
                'expectedArray' => [
                    'key' => 'value',
                    'anotherKey' => 'anotherValue',
                    'anotherArray.key' => 'value',
                    'anotherArray.yetAnother.key' => 'yetAnotherValue'
                ]
            ],
            'Large Multi dimensional' => [
                'array' => [
                    'key' => 'value',
                    'anotherKey' => 'anotherValue',
                    'anotherArray' => [
                        'key' => 'value',
                        'yetAnother' => [
                            'key' => 'yetAnotherValue',
                            'another' => [
                                'another' => [
                                    'another' => 'another value'
                                ]
                            ]
                        ]
                    ]
                ],
                'expectedArray' => [
                    'key' => 'value',
                    'anotherKey' => 'anotherValue',
                    'anotherArray.key' => 'value',
                    'anotherArray.yetAnother.key' => 'yetAnotherValue',
                    'anotherArray.yetAnother.another.another.another' => 'another value'
                ]
            ]
        ];
    }

    /**
     * @test
     */
    public function youShouldBeAbleToDefineCustomArrayGlue()
    {
        $array = [
            'multi' => [
                'dimensional' => 'is cool'
            ]
        ];

        $actual = ArrayHelper::flattenArray($array, [], '_');

        $this->assertSame(
            [
                'multi_dimensional' => 'is cool'
            ],
            $actual
        );
    }

    /**
     * @test
     */
    public function youShouldBeAbleToDefineCustomPrefix()
    {
        $array = [
            'multi' => [
                'dimensional' => 'cool'
            ]
        ];

        $actual = ArrayHelper::flattenArray($array, ['is'], '_');

        $this->assertSame(
            [
                'is_multi_dimensional' => 'cool'
            ],
            $actual
        );
    }
}
