<?php

namespace KaneMenicou\FastControllerBundle\Tests\Model\Config;

use KaneMenicou\FastControllerBundle\Model\Config\InstantiatedCrudRouteConfig;

class InstantiatedCrudRouteConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @expectedException \KaneMenicou\FastControllerBundle\Model\Exception\MissingCrudConfiguration
     * @expectedExceptionMessage Route is missing configuration for the entity
     */
    public function itWillThrowAnExceptionIfThereIsNoEntityConfig()
    {
        new InstantiatedCrudRouteConfig(['api' => true]);
    }

    /**
     * @test
     *
     * @expectedException \KaneMenicou\FastControllerBundle\Model\Exception\MissingCrudConfiguration
     * @expectedExceptionMessage Config 'API' for crud route is missing for the crud routes for entity entity
     */
    public function itWillThrowAnExceptionIfThereIsNoApiConfig()
    {
        new InstantiatedCrudRouteConfig(['entity' => 'entity']);
    }

    /**
     * @test
     *
     * @expectedException \KaneMenicou\FastControllerBundle\Model\Exception\MissingCrudConfiguration
     * @expectedExceptionMessage Config 'return type' for crud route is missing for the crud routes for entity entity
     */
    public function itWillThrowAnExceptionIfThereIsNoReturnTypeConfig()
    {
        new InstantiatedCrudRouteConfig(['api' => true, 'entity' => 'entity']);
    }

    /**
     * @test
     */
    public function itWillSetConfigCorrectly()
    {
        $config = new InstantiatedCrudRouteConfig(['entity' => 'someEntity', 'api' => true, 'returnType' => 'Json']);

        $this->assertSame(true, $config->isApi());
        $this->assertSame('someEntity', $config->getEntity());
    }
}
