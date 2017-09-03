<?php

namespace KaneMenicou\FastControllerBundle\Helper;

class StringHelper
{
    private const TO_UNDERSCORE_REGEX = '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])|-|\s+/';
    private const TO_CAMEL_REGEX = '/_|-/';

    /**
     * @param $string
     *
     * @return string
     */
    public static function getAsSnakeCase(string $string): string
    {
        return strtolower(
            preg_replace(
                self::TO_UNDERSCORE_REGEX,
                '_',
                $string
            )
        );
    }

    /**
     * @param string $string
     * @param bool $capitalizeFirst
     *
     * @return string
     */
    public static function getAsCamelCase(string $string, bool $capitalizeFirst = false): string
    {
        $replacedString = str_replace(
            ' ',
            '',
            ucwords(preg_replace(self::TO_CAMEL_REGEX, ' ', $string))
        );

        if (!$capitalizeFirst) {
            $replacedString[0] = strtolower($replacedString[0]);
        }

        return $replacedString;
    }
}