<?php

namespace KaneMenicou\FastControllerBundle\Model;

interface ViewResponseTransformerInterface extends NamedResponseTransformerInterface
{

    /**
     * @param array $dataArray
     * @param string $method
     *
     * @return string
     */
    public function transform(array $dataArray, string $method): string;
}
