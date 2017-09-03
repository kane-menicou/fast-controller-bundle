<?php

namespace KaneMenicou\FastControllerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fast_controller');
        $rootNode->
        children()
            ->arrayNode('api')->children()
                ->arrayNode('entities')->defaultValue([])->end()
                ->end()
                ->end()
            ->arrayNode('view')->children()
                ->arrayNode('entities')->defaultValue([])
                ->end()
                ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
