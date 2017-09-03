<?php

namespace KaneMenicou\FastControllerBundle\Tests\Helper;

use KaneMenicou\FastControllerBundle\Helper\StringHelper;

class StringHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider camelAndUnderscore
     *
     * @param string $string
     * @param string $expectedString
     */
    public function itWillChangeAStringToSnakeCase($string, $expectedString)
    {
        $this->assertSame(StringHelper::getAsSnakeCase($string), $expectedString);
    }

    /**
     * @return array
     */
    public function camelAndUnderscore()
    {
        return [
            'Some camel case string' => [
                'string' => 'CamelCaseString',
                'expectedString' => 'camel_case_string'
            ],
            'Single uppercase letter' => [
                'string' => 'C',
                'expectedString' => 'c'
            ],
            'Kebab case' => [
                'string' => 's-s-s',
                'expectedString' => 's_s_s'
            ],
            'Already snake case' => [
                'string' => 'snake_case',
                'expectedString' => 'snake_case'
            ],
            'Numbers' => [
                'string' => '123213123',
                'expectedString' => '123213123'
            ],
            'Spaces' => [
                'string' => 'some spaced string',
                'expectedString' => 'some_spaced_string'
            ]
        ];
    }

    /**
     * @test
     * @dataProvider otherToCamel
     *
     * @param string $string
     * @param string $expectedString
     */
    public function itWillChangeAStringToCamelCase($string, $expectedString)
    {
        $this->assertSame($expectedString, StringHelper::getAsCamelCase($string));
    }

    /**
     * @return array
     */
    public function otherToCamel()
    {
        return [
            'Some underscore' => [
                'string' => 'camel_case_string',
                'expectedString' => 'camelCaseString'
            ],
            'Single uppercase letter' => [
                'string' => 'C',
                'expectedString' => 'c'
            ],
            'Kebab case' => [
                'string' => 's-s-s',
                'expectedString' => 'sSS'
            ],
            'Already camel case' => [
                'string' => 'camelCase',
                'expectedString' => 'camelCase'
            ],
            'Numbers' => [
                'string' => '123213123',
                'expectedString' => '123213123'
            ],
            'Spaces' => [
                'string' => 'some spaced string',
                'expectedString' => 'someSpacedString'
            ]
        ];
    }

    /**
     * @test
     */
    public function itWillUppercaseTheFirstLetter()
    {
        $this->assertSame('CamelCase', StringHelper::getAsCamelCase('camel_case', true));
    }
}
