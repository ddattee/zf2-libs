<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 30/06/2015
 * Time: 11:19
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