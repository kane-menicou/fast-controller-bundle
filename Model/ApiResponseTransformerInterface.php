<?php

namespace KaneMenicou\FastControllerBundle\Model;

interface ApiResponseTransformerInterface extends NamedResponseTransformerInterface
{
    /**
     * @param string $data
     *
     * @return array
     */
    public function reverseTransform(string $data): array;

    /**
     * @param array $dataArray
     *
     * @return string
     */
    public function transform(array $dataArray): string;
}
