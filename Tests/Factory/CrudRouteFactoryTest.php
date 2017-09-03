<?php

namespace KaneMenicou\FastControllerBundle\Tests\Factory;

use KaneMenicou\FastControllerBundle\Factory\CrudRouteFactory;
use KaneMenicou\FastControllerBundle\Model\Config\InstantiatedCrudRouteConfig;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;

class CrudRouteFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider routes
     *
     * @param $routeName
     * @param $expectedName
     * @param $expectedPath
     * @param $expectedController
     * @param $expectedMethods
     */
    public function itCanConstructARouteFromPassedInParams(
        $routeName,
        $expectedName,
        $expectedPath,
        $expectedController,
        $expectedMethods
    )
    {
        $expectedRoute = new Route($expectedPath, ['_controller' => $expectedController], [], [], '', [], $expectedMethods);
        [$name, $route] = CrudRouteFactory::createNewRoute($routeName, 'someClass', false);

        $this->assertSame($expectedName, $name);
        $this->assertEquals($expectedRoute, $route);
    }

    /**
     * @return array
     */
    public function routes()
    {
        return [
            'View route' => [
                'routeName' => InstantiatedCrudRouteConfig::VIEW_ROUTE,
                'expectedName' => 'someclass_view',
                'expectedPath' => '/someclass/{id}',
                'expectedController' => 'FastControllerBundle:Resource:view',
                'expectedMethods' => [Request::METHOD_GET]
            ],
            'Edit route' => [
                'routeName' => InstantiatedCrudRouteConfig::EDIT_ROUTE,
                'expectedName' => 'someclass_edit',
                'expectedPath' => '/someclass/{id}/edit',
                'expectedController' => 'FastControllerBundle:Resource:edit',
                'expectedMethods' => [Request::METHOD_POST, Request::METHOD_GET]
            ],
            'Delete route' => [
                'routeName' => InstantiatedCrudRouteConfig::DELETE_ROUTE,
                'expectedName' => 'someclass_delete',
                'expectedPath' => '/someclass/{id}/delete',
                'expectedController' => 'FastControllerBundle:Resource:delete',
                'expectedMethods' => [Request::METHOD_DELETE, Request::METHOD_POST, Request::METHOD_GET]
            ],
            'New route' => [
                'routeName' => InstantiatedCrudRouteConfig::NEW_ROUTE,
                'expectedName' => 'someclass_new',
                'expectedPath' => '/someclass/new',
                'expectedController' => 'FastControllerBundle:Resource:new',
                'expectedMethods' => [Request::METHOD_POST, Request::METHOD_GET]
            ],
            'Index Route' => [
                'routeName' => InstantiatedCrudRouteConfig::INDEX_ROUTE,
                'expectedName' => 'someclass_index',
                'expectedPath' => '/someclass',
                'expectedController' => 'FastControllerBundle:Resource:index',
                'expectedMethods' => [Request::METHOD_GET]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider apiRoutes
     */
    public function itCanConstructARouteFromPassedInParamsForApis(
        $routeName,
        $expectedName,
        $expectedPath,
        $expectedController,
        $expectedMethods
    )
    {
        $expectedRoute = new Route($expectedPath, ['_controller' => $expectedController], [], [], '', [], $expectedMethods);
        [$name, $route] = CrudRouteFactory::createNewRoute($routeName, 'someClass', true);

        $this->assertSame($expectedName, $name);
        $this->assertEquals($expectedRoute, $route);
    }

    /**
     * @return array
     */
    public function apiRoutes()
    {
        return [
            'View route' => [
                'routeName' => InstantiatedCrudRouteConfig::VIEW_ROUTE,
                'expectedName' => 'someclass_api_view',
                'expectedPath' => '/someclass/{id}',
                'expectedController' => 'FastControllerBundle:Resource:view',
                'expectedMethods' => [Request::METHOD_GET]
            ],
            'Edit route' => [
                'routeName' => InstantiatedCrudRouteConfig::EDIT_ROUTE,
                'expectedName' => 'someclass_api_edit',
                'expectedPath' => '/someclass/{id}/edit',
                'expectedController' => 'FastControllerBundle:Resource:edit',
                'expectedMethods' => [Request::METHOD_POST]
            ],
            'Delete route' => [
                'routeName' => InstantiatedCrudRouteConfig::DELETE_ROUTE,
                'expectedName' => 'someclass_api_delete',
                'expectedPath' => '/someclass/{id}/delete',
                'expectedController' => 'FastControllerBundle:Resource:delete',
                'expectedMethods' => [Request::METHOD_DELETE]
            ],
            'New route' => [
                'routeName' => InstantiatedCrudRouteConfig::NEW_ROUTE,
                'expectedName' => 'someclass_api_new',
                'expectedPath' => '/someclass/new',
                'expectedController' => 'FastControllerBundle:Resource:new',
                'expectedMethods' => [Request::METHOD_POST]
            ],
            'Index Route' => [
                'routeName' => InstantiatedCrudRouteConfig::INDEX_ROUTE,
                'expectedName' => 'someclass_api_index',
                'expectedPath' => '/someclass',
                'expectedController' => 'FastControllerBundle:Resource:index',
                'expectedMethods' => [Request::METHOD_GET]
            ]
        ];
    }

    /**
     * @test
     */
    public function itCanOverrideDefaultControllers()
    {
        $expectedRoute = new Route('/someclass/new', ['_controller' => 'someOverideController'], [], [], '', [], [Request::METHOD_POST]);
        $return = CrudRouteFactory::createNewRoute(InstantiatedCrudRouteConfig::NEW_ROUTE, 'someClass', true, 'someOverideController');
        $route = $return[1];

        $this->assertEquals($expectedRoute, $route);
    }
}
