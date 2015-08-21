<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 30/06/2015
 * Time: 11:16
 */

namespace General\Utils\Php;

class PhpConf
{
	/**
	 * Retreive lower value that give upload max file size
	 * @return int
	 */
	public static function file_upload_max_size()
	{
		$max_size = -1;

		if ($max_size < 0) {
			// Start with post_max_size.
			$max_size = self::parse_size(ini_get('post_max_size'));

			// If upload_max_size is less, then reduce. Except if upload_max_size is
			// zero, which indicates no limit.
			$upload_max = self::parse_size(ini_get('upload_max_filesize'));
			if ($upload_max > 0 && $upload_max < $max_size) {
				$max_size = $upload_max;
			}
		}
		return $max_size;
	}

	/**
	 * Parse php ini file size
	 * @param string $size
	 * @return int
	 */
	public static function parse_size($size)
	{
		$unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
		$size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
		if ($unit) {
			// Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
			return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
		} else {
			return round($size);
		}
	}
}