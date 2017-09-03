<?php

namespace KaneMenicou\FastControllerBundle\Loader;

use KaneMenicou\FastControllerBundle\Factory\CrudRouteFactory;
use KaneMenicou\FastControllerBundle\Model\Config\InstantiatedCrudRouteConfig;
use KaneMenicou\FastControllerBundle\Model\Config\RouterCrudRouteConfig;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

class CrudRouteLoader extends Loader
{
    /**
     * @var RouterCrudRouteConfig
     */
    private $config;

    /**
     * @param RouterCrudRouteConfig $config
     */
    public function __construct(RouterCrudRouteConfig $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        $routes = new RouteCollection();

        $reflectionClass = new \ReflectionClass($resource);
        $shortName = strtolower($reflectionClass->getShortName());

        $routes->addPrefix('\\' . $shortName);

        $blackListedRoutes = $this->config->getBlackListedRoutes($resource, $this->isCrudApi($type));
        $routesToCreate = InstantiatedCrudRouteConfig::getRoutesWithBlackLists($blackListedRoutes);

        foreach ($routesToCreate as $routeName) {
            $routes->add(...CrudRouteFactory::createNewRoute(
                $routeName,
                $shortName,
                $this->isCrudApi($type)
            ));
        }

        return $routes;
    }

    /**
     * @param $type
     *
     * @return bool
     */
    private function isCrudApi($type)
    {
        return strtolower($type) === 'crudapi';
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return strtolower($type) === 'crud' || $this->isCrudApi($type);
    }
}
