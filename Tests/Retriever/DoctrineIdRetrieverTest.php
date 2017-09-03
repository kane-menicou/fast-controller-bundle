<?php

namespace KaneMenicou\FastControllerBundle\Tests\Retriever;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use KaneMenicou\FastControllerBundle\Retriever\DoctrineIdRetriever;

class DoctrineIdRetrieverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itWillGetAnIdsValueFromAnClass()
    {
        $class = new class
        {
            private $someId = 'This is a id value';
        };

        $mockEntityManager = $this->getMock(EntityManagerInterface::class);
        $classMetaData = new ClassMetadata('SomeClass');
        $classMetaData->setIdentifier(['someId']);

        $mockEntityManager->expects($this->once())->method('getClassMetadata')->willReturn($classMetaData);

        $retriever = new DoctrineIdRetriever($mockEntityManager);
        $this->assertSame('This is a id value', $retriever->getIdForEntity($class));
    }
}
