<?php

namespace KaneMenicou\FastControllerBundle\Tests\Loader;

use KaneMenicou\FastControllerBundle\Loader\CrudRouteLoader;
use KaneMenicou\FastControllerBundle\Model\Config\AbstractCrudRouteConfig;
use KaneMenicou\FastControllerBundle\Model\Config\RouterCrudRouteConfig;

class CrudRouteLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itWillLoadTheCorrectNumberOfRoutes()
    {
        $routeLoader = new CrudRouteLoader(new RouterCrudRouteConfig([]));

        $routes = $routeLoader->load(
            'KaneMenicou\FastControllerBundle\Tests\Stubs\FakeEntity',
            'crud'
        );

        $this->assertCount(5, $routes);
    }

    /**
     * @test
     */
    public function itWillSetTheCorrectRouteNamesToPaths()
    {
        $expectedRouteNames = [
            ['fakeentity_new' => '/fakeentity/new'],
            ['fakeentity_view' => '/fakeentity/{id}'],
            ['fakeentity_edit' => '/fakeentity/{id}/edit'],
            ['fakeentity_delete' => '/fakeentity/{id}/delete'],
            ['fakeentity_index' => '/fakeentity'],
        ];

        $routeLoader = new CrudRouteLoader(new RouterCrudRouteConfig([]));

        $routes = $routeLoader->load(
            'KaneMenicou\FastControllerBundle\Tests\Stubs\FakeEntity',
            'crud'
        );

        foreach ($routes as $name => $route) {
            $this->assertContains([$name => $route->getPath()], $expectedRouteNames);
        }
    }

    /**
     * @test
     */
    public function itWillSetTheCorrectRouteNamesToDefaultControllers()
    {
        $expectedRouteNames = [
            ['fakeentity_new' => 'FastControllerBundle:Resource:new'],
            ['fakeentity_view' => 'FastControllerBundle:Resource:view'],
            ['fakeentity_edit' => 'FastControllerBundle:Resource:edit'],
            ['fakeentity_delete' => 'FastControllerBundle:Resource:delete'],
            ['fakeentity_index' => 'FastControllerBundle:Resource:index'],
        ];

        $routeLoader = new CrudRouteLoader(new RouterCrudRouteConfig([]));

        $routes = $routeLoader->load(
            'KaneMenicou\FastControllerBundle\Tests\Stubs\FakeEntity',
            'crud'
        );


        foreach ($routes as $name => $route) {
            $this->assertContains([$name => $route->getDefault('_controller')], $expectedRouteNames);
        }
    }

    /**
     * @test
     * @dataProvider resourceTypes
     *
     * @param string $resourceType
     */
    public function itWillOnlySupportTheCorrectResourceType($resourceType)
    {
        $routeLoader = new CrudRouteLoader(new RouterCrudRouteConfig([]));

        $this->assertTrue($routeLoader->supports([], $resourceType));
    }

    /**
     * @return array
     */
    public function resourceTypes()
    {
        return [
            'lower case' => ['crud'],
            'upper case' => ['CRUD'],
            'mixed case' => ['Crud'],
            'lower case api' => ['crudapi'],
            'mixed case api' => ['CrudApi'],
            'Upper case api' => ['CRUDAPI'],
        ];
    }

    /**
     * @test
     */
    public function itCanBlackListRoutes()
    {
        $routeLoader = new CrudRouteLoader(
            new RouterCrudRouteConfig([
                ['api' => [
                    'entities' => [
                        'KaneMenicou\FastControllerBundle\Tests\Stubs\FakeEntity' => [
                            'black_listed_routes' => [
                                AbstractCrudRouteConfig::VIEW_ROUTE,
                                AbstractCrudRouteConfig::EDIT_ROUTE
                            ]
                        ]
                    ]
                ]]
            ])
        );

        $routes = $routeLoader->load('KaneMenicou\FastControllerBundle\Tests\Stubs\FakeEntity', 'CrudApi');

        $expectedRouteNames = [
            ['fakeentity_api_new' => 'FastControllerBundle:Resource:new'],
            ['fakeentity_api_delete' => 'FastControllerBundle:Resource:delete'],
            ['fakeentity_api_index' => 'FastControllerBundle:Resource:index'],
        ];

        foreach ($routes as $name => $route) {
            $this->assertContains([$name => $route->getDefault('_controller')], $expectedRouteNames);
        }
    }
}
