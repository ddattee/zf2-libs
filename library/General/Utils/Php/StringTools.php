<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 30/06/2015
 * Time: 11:20
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