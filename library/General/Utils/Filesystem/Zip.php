<?php
/**
 * Zip utilities functions
 *
 * @category  General
 * @package   General\Utils\Filesystem
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Utils\Filesystem;

class Zip
{

    /**
     * Recursivly add a directory to a Zip archive
     *
     * @param ZipArchive $zip The Zip to add to
     * @param string $dir The absolute path to the directory to add
     * @param boolean $absolute_path Defautl false
     * @return ZipArchive
     */
    public static function addDirectoryToZip($zip, $dir, $absolute_path = true, $curr_dir = '')
    {
        $root_dir = ($absolute_path ? $curr_dir . substr($dir, strrpos($dir, '/') + 1) : $dir);
        $zip->addEmptyDir($root_dir);
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file)) {
                $zip = self::addDirectoryToZip($zip, $file, $absolute_path, $root_dir . '/');
            } else {
                $zip->addFile($file, ($absolute_path ? $root_dir . '/' . substr($file, strrpos($file, '/') + 1) : $file));
            }
        }
        return $zip;
    }
}
