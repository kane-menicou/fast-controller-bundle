<?php

namespace KaneMenicou\FastControllerBundle\Tests\DependencyInjection\Compiler;

use KaneMenicou\FastControllerBundle\Chain\ResponseTransformerChain;
use KaneMenicou\FastControllerBundle\DependencyInjection\Compiler\ViewResponseTransformerPass;
use KaneMenicou\FastControllerBundle\Model\ApiResponseTransformerInterface;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ViewResponseTransformerPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itWillAddNoResponseTransformerIfThereIsNoChainDefined()
    {
        $pass = new ViewResponseTransformerPass;

        /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder $mockContainer */
        $mockContainer = $this->getMockBuilder(ContainerBuilder::class)->getMock();

        $mockContainer->expects($this->once())->method('registerForAutoconfiguration')->willReturn(
            new ChildDefinition('parent')
        );

        $mockContainer->expects($this->once())->method('has')->with(
            'kane_menicou_fast_controller.chain.view_response_transformer_chain'
        )->willReturn(false);

        $mockContainer->expects($this->never())->method('findTaggedServiceIds');

        $pass->process($mockContainer);
    }

    /**
     * @test
     */
    public function itWillAddResponseTransformersToTheChainIfThereDefined()
    {
        $transformer = new class implements ApiResponseTransformerInterface
        {

            /**
             * {@inheritdoc}
             */
            public function transform(array $dataArray): string
            {
                return '';
            }

            /**
             * {@inheritdoc}
             */
            public function reverseTransform(string $data): array
            {
                return [];
            }

            /**
             * {@inheritdoc}
             */
            public function getName(): string
            {
                return 'transformer';
            }
        };

        $pass = new ViewResponseTransformerPass;

        /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerBuilder $mockContainer */
        $mockContainer = $this->getMockBuilder(ContainerBuilder::class)->getMock();

        $mockContainer->expects($this->once())->method('registerForAutoconfiguration')->willReturn(
            new ChildDefinition('parent')
        );

        $mockContainer->expects($this->once())->method('has')->with(
            'kane_menicou_fast_controller.chain.view_response_transformer_chain'
        )->willReturn(true);

        $mockContainer->expects($this->once())->method('findDefinition')
            ->with('kane_menicou_fast_controller.chain.view_response_transformer_chain')
            ->willReturn($mockDefinition = $this->getMock(Definition::class));

        $mockContainer->expects($this->once())->method('findTaggedServiceIds')
            ->with('kane_menicou_fast_controller.view_response_transformer')->willReturn([$transformer]);

        $mockDefinition->expects($this->once())->method('addMethodCall')
            ->with('addResponseTransformer', [new Reference('0')]);

        $expectedChain = new ResponseTransformerChain();
        $expectedChain->addResponseTransformer($transformer);

        $pass->process($mockContainer);
    }
}
