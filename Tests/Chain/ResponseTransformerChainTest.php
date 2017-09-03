<?php

namespace KaneMenicou\FastControllerBundle\Tests\Chain;

use KaneMenicou\FastControllerBundle\Chain\ResponseTransformerChain;
use KaneMenicou\FastControllerBundle\Model\ApiResponseTransformerInterface;

class ResponseTransformerChainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @expectedException \KaneMenicou\FastControllerBundle\Model\Exception\CouldNotFindResponseTransformerException
     * @expectedExceptionMessage Could not find response transformer called notRealTransformerChain
     */
    public function itWillThrowAnExceptionIfItCannotFindATransformerWithTheCorrectName()
    {
        $transformer1 = new class implements ApiResponseTransformerInterface
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
                return 'someResponseTransformer';
            }
        };

        $responseTransformerChain = new ResponseTransformerChain();

        $responseTransformerChain->addResponseTransformer($transformer1);

        $responseTransformerChain->getResponseTransformer('notRealTransformerChain');
    }

    /**
     * @test
     *
     * @expectedException \KaneMenicou\FastControllerBundle\Model\Exception\FoundMoreThanOneResponseTransformerException
     * @expectedExceptionMessage Found 2 response transformers called someResponseTransformer (more than one)
     */
    public function itWillThrowAnExceptionIfThereAreTwoResponseTransformersWithTheSameName()
    {
        $transformer1 = new class implements ApiResponseTransformerInterface
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
                return 'someResponseTransformer';
            }
        };

        $transformer2 = new class implements ApiResponseTransformerInterface
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
                return 'someResponseTransformer';
            }
        };

        $responseTransformerChain = new ResponseTransformerChain();

        $responseTransformerChain->addResponseTransformer($transformer1);
        $responseTransformerChain->addResponseTransformer($transformer2);

        $responseTransformerChain->getResponseTransformer('someResponseTransformer');
    }

    /**
     * @test
     */
    public function itWillFindTheValidResponseTransformer()
    {
        $transformer1 = new class implements ApiResponseTransformerInterface
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
                return 'someResponseTransformer1';
            }
        };

        $transformer2 = new class implements ApiResponseTransformerInterface
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
                return 'someResponseTransformer2';
            }
        };

        $responseTransformerChain = new ResponseTransformerChain();

        $responseTransformerChain->addResponseTransformer($transformer1);
        $responseTransformerChain->addResponseTransformer($transformer2);

        $found = $responseTransformerChain->getResponseTransformer('someResponseTransformer1');

        $this->assertSame($transformer1, $found);
    }
}
