<?php

namespace KaneMenicou\FastControllerBundle\Twig\Extension;

use Twig_SimpleFilter;

class TypeExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('isDateTime', [$this, 'isDateTime'])
        ];
    }

    /**
     * @param $isDateTime
     * @return bool
     */
    public function isDateTime($isDateTime)
    {
        return $isDateTime instanceof \DateTimeInterface;
    }
}
