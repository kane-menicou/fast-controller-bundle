<?php

namespace KaneMenicou\FastControllerBundle\Model\Config;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractCrudRouteConfig
{
    public const NEW_ROUTE = 'new';
    public const VIEW_ROUTE = 'view';
    public const EDIT_ROUTE = 'edit';
    public const DELETE_ROUTE = 'delete';
    public const INDEX_ROUTE = 'index';


    /**
     * @return array
     */
    public static function getRouteConfig()
    {
        return [
            self::NEW_ROUTE => [
                'name' => '%s_new',
                'apiName' => '%s_api_new',
                'path' => '/%s/new',
                'defaultController' => 'FastControllerBundle:Resource:new',
                'apiMethods' => [Request::METHOD_POST],
                'nonApiMethods' => [Request::METHOD_POST, Request::METHOD_GET]

            ],
            self::VIEW_ROUTE => [
                'name' => '%s_view',
                'apiName' => '%s_api_view',
                'path' => '/%s/{id}',
                'defaultController' => 'FastControllerBundle:Resource:view',
                'apiMethods' => [Request::METHOD_GET],
                'nonApiMethods' => [Request::METHOD_GET]

            ],
            self::EDIT_ROUTE => [
                'name' => '%s_edit',
                'apiName' => '%s_api_edit',
                'path' => '/%s/{id}/edit',
                'defaultController' => 'FastControllerBundle:Resource:edit',
                'apiMethods' => [Request::METHOD_POST],
                'nonApiMethods' => [Request::METHOD_POST, Request::METHOD_GET]
            ],
            self::DELETE_ROUTE => [
                'name' => '%s_delete',
                'apiName' => '%s_api_delete',
                'path' => '/%s/{id}/delete',
                'defaultController' => 'FastControllerBundle:Resource:delete',
                'apiMethods' => [Request::METHOD_DELETE],
                'nonApiMethods' => [Request::METHOD_DELETE, Request::METHOD_POST, Request::METHOD_GET]
            ],
            self::INDEX_ROUTE => [
                'name' => '%s_index',
                'apiName' => '%s_api_index',
                'path' => '/%s',
                'defaultController' => 'FastControllerBundle:Resource:index',
                'apiMethods' => [Request::METHOD_GET],
                'nonApiMethods' => [Request::METHOD_GET]
            ]
        ];
    }

    /**
     * @return array
     */
    public static function getAllAvailableRoutes()
    {
        return [
            self::NEW_ROUTE,
            self::VIEW_ROUTE,
            self::EDIT_ROUTE,
            self::DELETE_ROUTE,
            self::INDEX_ROUTE
        ];
    }

    /**
     * @param array $blackListed
     *
     * @return array
     */
    public static function getRoutesWithBlackLists(array $blackListed): array
    {
        $routesToReturn = self::getAllAvailableRoutes();

        foreach ($routesToReturn as $key => $route) {
            if (in_array($route, $blackListed)) {
                unset($routesToReturn[$key]);
            }
        }

        return $routesToReturn;
    }
}
