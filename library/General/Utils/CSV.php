<?php
/**
 * CSV utilities functions
 *
 * @category  General
 * @package   General\Utils
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Utils;

class Csv
{
    /**
     * Writes an array of objects to a specified CSV file
     * @param array $objects Array of objects
     * @param string $file The file's path and nam
     * @param array $header The fields to be writen on the first line (optional)
     * @param string $delimiter Character put in between each field (default: ';')
     */
    public static function objectsToCSV($objects, $file, $header = array(), $delimiter = ';')
    {
        $fp = fopen($file, 'w');

        if (!empty($header))
            fputcsv($fp, $header, $delimiter);

        foreach ($objects as $object) {
            $fields = array_shift($object->toArray());
            var_dump($fields);
            fputcsv($fp, $fields, $delimiter);
        }

        fclose($fp);
    }
}
