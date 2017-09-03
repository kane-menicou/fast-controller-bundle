<?php

namespace KaneMenicou\FastControllerBundle\Model;

interface NamedResponseTransformerInterface
{
    /**
     * @return string
     */
    public function getName(): string;
}