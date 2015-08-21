<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 30/06/2015
 * Time: 11:16
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

}