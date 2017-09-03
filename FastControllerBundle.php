<?php

namespace KaneMenicou\FastControllerBundle;

use KaneMenicou\FastControllerBundle\DependencyInjection\Compiler\ApiResponseTransformerPass;
use KaneMenicou\FastControllerBundle\DependencyInjection\Compiler\ViewResponseTransformerPass;
use KaneMenicou\FastControllerBundle\DependencyInjection\FastControllerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FastControllerBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ViewResponseTransformerPass);
        $container->addCompilerPass(new ApiResponseTransformerPass);
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new FastControllerExtension;
    }
}
