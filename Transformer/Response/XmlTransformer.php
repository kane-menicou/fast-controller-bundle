<?php

namespace KaneMenicou\FastControllerBundle\Transformer\Response;

use KaneMenicou\FastControllerBundle\Model\ApiResponseTransformerInterface;
use SimpleXMLElement;

class XmlTransformer implements ApiResponseTransformerInterface
{

    /**
     * {@inheritdoc}
     */
    public function transform(array $dataArray): string
    {
        $xml = new SimpleXMLElement('<root/>');
        $dataArray = array_flip($dataArray);
        array_walk_recursive($dataArray, [$xml, 'addChild']);

        return $xml->asXML();
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
        return 'xml';
    }
}