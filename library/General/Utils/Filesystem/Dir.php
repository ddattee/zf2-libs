<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 30/06/2015
 * Time: 11:16
 */

namespace General\Utils\Filesystem;


class Dir
{

	/**
	 * Return the requested directory size
	 *
	 * @param string $path
	 * @return string|false
	 */
	public static function dirSize($path, $pretify = false)
	{
		if (is_dir($path)) {
			$io = popen('/usr/bin/du -sk' . ($pretify ? 'h' : '') . ' ' . $path, 'r');
			if (false != $io) {
				$size = (string)fgets($io);
				pclose($io);
				return substr($size, 0, strpos($size, substr($path, 0, 1)) - 1);
			}
			return $io;
		} else {
			return false;
		}
	}

	/**
	 * Delete a directory and all its content
	 *
	 * @param string $dir
	 * @return boolean
	 */
	public static function rrmdir($dir)
	{
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir . "/" . $object) == "dir")
						self::rrmdir($dir . "/" . $object);
					else
						unlink($dir . "/" . $object);
				}
			}
			reset($objects);
			return rmdir($dir);
		}
		return false;
	}

	/**
	 * Convert any * in directory name to x to be URL compatible
	 *
	 * @param string $chaine
	 * @return mixed
	 */
	public static function adapt_dir_url($chaine)
	{
		$patterns = array(
			'/\*/'
		);
		$replacements = array(
			'x'
		);
		return preg_replace($patterns, $replacements, $chaine);
	}

	/**
	 * Count the number of file into a folder
	 * @param string $path
	 * @param array $filter_extensions Allow to only count certain file type by extension
	 * @return int
	 */
	public static function countFiles($path, $filter_extensions = array())
	{
		$count = 0;
		foreach (new \FilesystemIterator(realpath($path), \FilesystemIterator::SKIP_DOTS) as $file) {
			if ($file->isFile() &&
				(empty($filter_extensions) || in_array($file->getExtension(), $filter_extensions))
			) {
				$count++;
			}
		}
		return $count;
	}
}