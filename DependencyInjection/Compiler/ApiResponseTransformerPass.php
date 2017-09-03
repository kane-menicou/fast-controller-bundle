<?php

namespace KaneMenicou\FastControllerBundle\DependencyInjection\Compiler;

use KaneMenicou\FastControllerBundle\Model\ApiResponseTransformerInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ApiResponseTransformerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(ApiResponseTransformerInterface::class)
            ->addTag('kane_menicou_fast_controller.response_transformer');

        if (!$container->has('kane_menicou_fast_controller.chain.api_response_transformer_chain')) {
            return;
        }

        $definition = $container->findDefinition('kane_menicou_fast_controller.chain.api_response_transformer_chain');

        $taggedServices = $container->findTaggedServiceIds('kane_menicou_fast_controller.api_response_transformer');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addResponseTransformer', [new Reference($id)]);
        }
    }
}