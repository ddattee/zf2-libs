<?php
/**
 * String utilities functions
 *
 * @category  General
 * @package   General\Utils\Php
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Utils\Php;

class StringTools
{
    /**
     * Detect if the string is Json or not
     *
     * @param string $string
     * @return boolean
     */
    public static function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Echo the given data in a textarea
     * @param string $data
     * @param int $height Default 500
     * @return string
     */
    public static function txtarea($data, $height = 500)
    {
        return '<textarea style="width:100%;height:' . $height . 'px;">' . $data . '</textarea>';
    }
}
