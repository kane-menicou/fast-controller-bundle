<?php

namespace KaneMenicou\FastControllerBundle\Tests\Twig\Extension;

use KaneMenicou\FastControllerBundle\Tests\Stubs\FakeEntity;
use KaneMenicou\FastControllerBundle\Twig\Extension\TypeExtension;

class TypeExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider objectsToIsDateTime
     * @param $value
     * @param bool $shouldPass
     */
    public function itWillResolveDateTimesCorrectly($value, bool $shouldPass)
    {
        $type = new TypeExtension;
        $this->assertSame($shouldPass, $type->isDateTime($value));
    }

    /**
     * @return array
     */
    public function objectsToIsDateTime(): array
    {
        return [
            'Is date time' => [
                'value' => new \DateTime,
                'shouldPass' => true
            ],
            'Is another datetime' => [
                'value' => new \DateTimeImmutable,
                'shouldPass' => true
            ],
            'Non object' => [
                'value' => 'string',
                'shouldPass' => false
            ],
            'Wrong object' => [
                'value' => new FakeEntity,
                'shouldPass' => false
            ],
        ];
    }
}
