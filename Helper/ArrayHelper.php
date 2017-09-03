<?php

namespace KaneMenicou\FastControllerBundle\Helper;

class ArrayHelper
{
    /**
     * @param array $array
     * @param array $prefixKeys
     *
     * @return array
     */
    public static function flattenArray(array $array, array $prefixKeys = [], string $flatArrayGlue = '.')
    {
        $newArray = [];
        $prefixString = '';

        if ($prefixKeys !== []) {
            $prefixString = implode($flatArrayGlue, $prefixKeys) . $flatArrayGlue;
        }

        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                $newArray[$prefixString . $key] = $value;
                continue;
            }

            $prefixKeys[] = $key;

            self::setAndMerge($newArray, self::flattenArray($value, $prefixKeys, $flatArrayGlue));
        }

        return $newArray;
    }

    /**
     * @param array $array
     * @param array $mergeArray
     */
    public static function setAndMerge(array &$array, array $mergeArray)
    {
        $array = array_merge($array, $mergeArray);
    }
}