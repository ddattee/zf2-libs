<?php
/**
 * File utilities functions
 *
 * @category  General
 * @package   General\Utils\Filesystem
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Utils\Filesystem;

class File
{
    /**
     * Extract the extension of a filename
     * @param $filename
     * @return mixed
     */
    public static function getExtension($filename)
    {
        return substr($filename, strrpos($filename, '.'));
    }

    /**
     * Format Bytes value into the appropriate format (o, Mo, Go, To)
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    public static function formatBytes($bytes, $precision = 2) {
        $units = array('o', 'Ko', 'Mo', 'Go', 'To');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
