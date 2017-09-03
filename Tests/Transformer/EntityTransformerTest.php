<?php

namespace KaneMenicou\FastControllerBundle\Tests\Transformer;

use KaneMenicou\FastControllerBundle\Transformer\EntityTransformer;
use KaneMenicou\FastControllerBundle\Transformer\Response\JsonTransformer;

class EntityTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itWillConvertAnEntityCorrectly()
    {
        $expectedArray = [
            'some_val_1' => 'value of 1',
            'some_val_2' => 'value of 2'
        ];

        $entity = new class ()
        {
            private $someVal1 = 'value of 1';

            public $someVal2 = 'value of 2';
        };

        $transformer = new EntityTransformer;

        $this->assertSame($expectedArray, $transformer->transform($entity));
    }

    /**
     * @test
     */
    public function itCanBePassedAValidResponseTransformer()
    {
        $expectedValue = '{"some_val_1":"value of 1","some_val_2":"value of 2"}';

        $entity = new class ()
        {
            private $someVal1 = 'value of 1';

            private $someVal2 = 'value of 2';
        };

        $transformer = new EntityTransformer;
        $json = new JsonTransformer;

        $this->assertSame($expectedValue, $transformer->transform($entity, $json));
    }

    /**
     * @test
     */
    public function itCanExcludeProperties()
    {
        $expectedValue = '{"some_val_1":"value of 1","some_val_2":"value of 2"}';

        $entity = new class ()
        {
            private $someVal1 = 'value of 1';

            private $someVal2 = 'value of 2';

            private $thisValueShouldNotBeHere = 'This value should not be here';
        };

        $transformer = new EntityTransformer;
        $json = new JsonTransformer;

        $this->assertSame($expectedValue, $transformer->transform($entity, $json, ['thisValueShouldNotBeHere']));
    }

    /**
     * @test
     */
    public function itCanExcludePropertiesInSnakeCase()
    {
        $expectedValue = '{"some_val_1":"value of 1","some_val_2":"value of 2"}';

        $entity = new class ()
        {
            private $someVal1 = 'value of 1';

            private $someVal2 = 'value of 2';

            private $thisValueShouldNotBeHere = 'This value should not be here';
        };

        $transformer = new EntityTransformer;
        $json = new JsonTransformer;

        $this->assertSame($expectedValue, $transformer->transform(
            $entity,
            $json,
            ['this_value_should_not_be_here']
        ));
    }
}
