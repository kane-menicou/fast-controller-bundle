<?php

namespace KaneMenicou\FastControllerBundle\Transformer\Response;

use KaneMenicou\FastControllerBundle\Model\ApiResponseTransformerInterface;

class JsonTransformer implements ApiResponseTransformerInterface
{

    /**
     * {@inheritdoc}
     */
    public function transform(array $dataArray): string
    {
        return json_encode($dataArray);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform(string $data): array
    {
        return json_decode($data, true);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Json';
    }
}