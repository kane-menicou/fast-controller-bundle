<?php

namespace KaneMenicou\FastControllerBundle\Factory;

use KaneMenicou\FastControllerBundle\Model\Config\InstantiatedCrudRouteConfig;
use Symfony\Component\Routing\Route;

class CrudRouteFactory
{
    /**
     * @param string $classShortName
     * @param bool $isApi
     * @param string|null $overrideController
     *
     * @return array
     */
    public static function createNewRoute(
        string $routeName,
        string $classShortName,
        bool $isApi,
        string $overrideController = null
    )
    {
        $routeConfig = self::getRouteConfig($routeName);

        $route = new Route(
            strtolower(sprintf($routeConfig['path'], $classShortName)),
            $overrideController ?
                ['_controller' => $overrideController] :
                ['_controller' => $routeConfig['defaultController']],
            [],
            [],
            '',
            [],
            $isApi ? $routeConfig['apiMethods'] : $routeConfig['nonApiMethods']
        );

        return [
            self::getRouteName($routeConfig, $classShortName, $isApi),
            $route
        ];
    }

    /**
     * @param $routeName
     *
     * @return array
     */
    private static function getRouteConfig($routeName)
    {
        return self::getCrudRoutes()[$routeName];
    }

    /**
     * @return array
     */
    private static function getCrudRoutes()
    {
        return InstantiatedCrudRouteConfig::getRouteConfig();
    }

    /**
     * @param array $routeConfig
     * @param string $classShortName
     * @param bool $isApi
     *
     * @return string
     */
    private static function getRouteName(array $routeConfig, string $classShortName, bool $isApi)
    {
        $routeName = $routeConfig['name'];

        if ($isApi) {
            $routeName = $routeConfig['apiName'];
        }

        return strtolower(sprintf($routeName, $classShortName));
    }
}