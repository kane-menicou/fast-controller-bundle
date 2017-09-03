<?php

namespace KaneMenicou\FastControllerBundle\Model\Config;

use KaneMenicou\FastControllerBundle\Model\Exception\InvalidCrudRoutingException;

class RouterCrudRouteConfig extends AbstractCrudRouteConfig
{
    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (isset($config[0])) {
            $this->config = $config[0];
        }
    }

    /**
     * @param string $entity
     * @param bool $isApi
     *
     * @return array
     *
     * @throws InvalidCrudRoutingException
     */
    public function getBlackListedRoutes(string $entity, bool $isApi = false): array
    {
        if (!isset($this->config[$isApi ? 'api' : 'view'])) {
            return [];
        }

        $config = $this->config[$isApi ? 'api' : 'view'];

        if (!isset($config['entities'])) {
            return [];
        }

        $entities = $config['entities'];

        if (!isset($entities[$entity])) {
            return [];
        }

        $entityConfig = $entities[$entity];

        if (!isset($entityConfig['black_listed_routes'])) {
            return [];
        }

        foreach ($entityConfig['black_listed_routes'] as $route) {
            if (!in_array($route, self::getAllAvailableRoutes())) {
                $validRoutes = implode(',', self::getAllAvailableRoutes());
                throw new InvalidCrudRoutingException(
                    "$route is not a valid route to blacklist for the entity $entity. Valid routes are $validRoutes"
                );
            }
        }

        return $entityConfig['black_listed_routes'];
    }
}
