<?php

namespace KaneMenicou\FastControllerBundle\Tests\Model\Config;

use KaneMenicou\FastControllerBundle\Model\Config\RouterCrudRouteConfig;

class RouterCrudRouteConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @expectedException \KaneMenicou\FastControllerBundle\Model\Exception\InvalidCrudRoutingException
     */
    public function itWillThrowAnExceptionIfThereIsAnInvalidRouteInTheConfig()
    {
        $config = [
            [
                'api' => [
                    'entities' => [
                        'SomeEntity' => [
                            'black_listed_routes' => [
                                'invalid route'
                            ]

                        ]
                    ]
                ]
            ]
        ];

        $routerConfig = new RouterCrudRouteConfig($config);

        $routerConfig->getBlackListedRoutes('SomeEntity', true);
    }

    /**
     * @test
     */
    public function itWillReturnTheConfigForTheRoutesThatAreBlackListed()
    {
        $config = [
            [
                'api' => [
                    'entities' => [
                        'SomeEntity' => [
                            'black_listed_routes' => [
                                RouterCrudRouteConfig::VIEW_ROUTE
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $routerConfig = new RouterCrudRouteConfig($config);

        $blackListedRoutes = $routerConfig->getBlackListedRoutes('SomeEntity', true);

        $this->assertSame([RouterCrudRouteConfig::VIEW_ROUTE], $blackListedRoutes);
    }
}
