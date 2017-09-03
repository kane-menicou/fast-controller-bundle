<?php

namespace KaneMenicou\FastControllerBundle\Chain;

use KaneMenicou\FastControllerBundle\Model\ApiResponseTransformerInterface;
use KaneMenicou\FastControllerBundle\Model\Exception\CouldNotFindResponseTransformerException;
use KaneMenicou\FastControllerBundle\Model\Exception\FoundMoreThanOneResponseTransformerException;
use KaneMenicou\FastControllerBundle\Model\NamedResponseTransformerInterface;
use KaneMenicou\FastControllerBundle\Model\ViewResponseTransformerInterface;

class ResponseTransformerChain
{
    /**
     * @var NamedResponseTransformerInterface[]
     */
    private $responseTransformers;

    public function __construct()
    {
        $this->responseTransformers = [];
    }

    /**
     * @param NamedResponseTransformerInterface $responseTransformer
     */
    public function addResponseTransformer(NamedResponseTransformerInterface $responseTransformer)
    {
        $this->responseTransformers[] = $responseTransformer;
    }

    /**
     * @param string $name
     *
     * @return NamedResponseTransformerInterface|ApiResponseTransformerInterface|ViewResponseTransformerInterface
     *
     * @throws CouldNotFindResponseTransformerException
     * @throws FoundMoreThanOneResponseTransformerException
     */
    public function getResponseTransformer(string $name): NamedResponseTransformerInterface
    {
        $foundResponseTransformers = [];

        foreach ($this->responseTransformers as $responseTransformer) {
            if ($responseTransformer->getName() === $name) {
                $foundResponseTransformers[] = $responseTransformer;
            }
        }

        $numberOfResponseTransformerFound = count($foundResponseTransformers);

        if ($numberOfResponseTransformerFound < 1) {
            throw new CouldNotFindResponseTransformerException(
                "Could not find response transformer called $name"
            );
        }

        if ($numberOfResponseTransformerFound > 1) {
            throw new FoundMoreThanOneResponseTransformerException(
                "Found $numberOfResponseTransformerFound response transformers called $name (more than one)"
            );
        }

        return $foundResponseTransformers[0];
    }
}
