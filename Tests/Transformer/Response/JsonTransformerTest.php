<?php

namespace KaneMenicou\FastControllerBundle\Tests\Transformer\Response;

use KaneMenicou\FastControllerBundle\Transformer\Response\JsonTransformer;

class JsonTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider arraysAndExpectedJson
     *
     * @param array $array
     * @param string $expectedJson
     */
    public function itWillCorrectTransformAnArrayIntoJson($array, $expectedJson)
    {
        $json = new JsonTransformer;

        $this->assertSame($expectedJson, $json->transform($array));
    }

    /**
     * @return array
     */
    public function arraysAndExpectedJson()
    {
        return [
            'Single dimension array' => [
                'array' => [
                    'message' => 'single dimension'
                ],
                'expectedJson' => '{"message":"single dimension"}'
            ],
            'Multi dimension array' => [
                'array' => [
                    'message' => 'multi dimension',
                    'Others' => [
                        'hi' => 'hi'
                    ]
                ],
                'expectedJson' => '{"message":"multi dimension","Others":{"hi":"hi"}}'
            ],
            'Json array' => [
                'array' => [
                    'some value'
                ],
                'expectedJson' => '["some value"]'
            ]
        ];
    }

    /**
     * @test
     * @dataProvider jsonAndExpectedArray
     *
     * @param array $array
     * @param string $jsonString
     */
    public function itWillCorrectTransformJsonIntoAnArray($array, $jsonString)
    {
        $json = new JsonTransformer;

        $this->assertSame($array, $json->reverseTransform($jsonString));
    }

    /**
     * @return array
     */
    public function jsonAndExpectedArray()
    {
        return [
            'Single dimension array' => [
                'array' => [
                    'message' => 'single dimension'
                ],
                'jsonString' => '{"message":"single dimension"}'
            ],
            'Multi dimension array' => [
                'array' => [
                    'message' => 'multi dimension',
                    'Others' => [
                        'hi' => 'hi'
                    ]
                ],
                'jsonString' => '{"message":"multi dimension","Others":{"hi":"hi"}}'
            ],
            'Json array' => [
                'array' => [
                    'some value'
                ],
                'jsonString' => '["some value"]'
            ]
        ];
    }
}
