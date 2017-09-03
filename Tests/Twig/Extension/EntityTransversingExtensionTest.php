<?php

namespace KaneMenicou\FastControllerBundle\Tests\Twig\Extension;

use KaneMenicou\FastControllerBundle\Retriever\DoctrineIdRetriever;
use KaneMenicou\FastControllerBundle\Tests\Stubs\FakeEntity;
use KaneMenicou\FastControllerBundle\Transformer\EntityTransformer;
use KaneMenicou\FastControllerBundle\Twig\Extension\EntityTransversingExtension;

class EntityTransversingExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itCanGetAnEntitiesShortName()
    {
        $extension = new EntityTransversingExtension(
            $this->getMock(EntityTransformer::class, [], [], '', false),
            $this->getMock(DoctrineIdRetriever::class, [], [], '', false)
        );

        $name = $extension->getEntityName(new FakeEntity);

        $this->assertSame($name, 'FakeEntity');
    }
}
