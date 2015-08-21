<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 30/06/2015
 * Time: 11:18
 */

namespace General\Utils\Php;


use General\Filter\NoSpecialchar;

class ArrayTools
{

	/**
	 * Cleanup the special char of an array
	 *
	 * @param array $array
	 * @return array
	 */
	public static function arrayCleanUpSpecialchar(array $array, General_Filter_NoSpecialchar $filter = null)
	{
		$filter = (empty($filter) ? new NoSpecialchar() : $filter);
		foreach ($array as $key => $val) {
			if (!is_array($val)) {
				$array[$key] = $filter->filter(utf_encode($val));
			} else {
				$array[$key] = self::arrayCleanUpSpecialchar($val, $filter);
			}
		}
		return $array;
	}

	/**
	 * Transform an array to HTML
	 *
	 * @param array $array
	 * @return string
	 */
	public static function arrayToHtml(array $array, NoSpecialchar $filter = null)
	{
		$filter = (empty($filter) ? new NoSpecialchar() : $filter);
		$html = '<table class="table table-stripped">';
		foreach ($array as $key => $val) {
			$html .= "<tr><td>" . $key . "</td><td>" . (!is_array($val) ? utf8_encode($filter->filter($val)) : self::arrayToHtml($val, $filter)) . "</td></tr>";
		}
		$html .= '</table>';
		return $html;
	}

	/**
	 * Convert an array of model to a 2 dimensions array to fieul a select
	 *
	 * @param array $array Array of models/array
	 * @param string $keyLabel Propertie of the model to be used as label
	 * @param string $keyValue Propertie of the model to be used as value default: id
	 * @return array
	 */
	public static function arrayToSelect(array $array, $keyLabel, $keyValue = 'id')
	{

		$selectArray = array();
		foreach ($array as $item) {
			if (is_object($item)) {
				$selectArray[$item->{$keyValue}] = $item->{$keyLabel};
			} elseif (is_array($item)) {
				if (isset($item[$keyValue]) && $item[$keyLabel]) {
					$selectArray[$item[$keyValue]] = $item[$keyLabel];
				}
			}
		}

		return $selectArray;
	}

	/**
	 * Flaten an array into a string using $separator between values
	 *
	 * @param array $array
	 * @param string $separator
	 * @return string
	 */
	public static function arrayToString(array $array, $separator = '')
	{
		$result = '';
		foreach ($array as $key => $val) {
			if (!is_array($val)) {
				$result .= (string)(!empty($result) ? $separator : '') . $key . $val;
			} else {
				$result .= self::arrayToString($val, $separator);
			}
		}
		return (string)$result;
	}

	/**
	 * Clean up empty values in an array
	 *
	 * @param array $array
	 * @return array
	 */
	public static function arrayCleanUpEmpty(array &$array)
	{
		foreach ($array as $key => $val) {
			if (empty($val))
				unset($array[$key]);
		}
		return $array;
	}

	/**
	 * Incremental deep search in array, only search on the values (not the keys)
	 *
	 * @param mixed $needle
	 * @param array $haystack
	 * @return boolean
	 */
	public static function arrayDeepSearch($needle, $haystack)
	{
		foreach ($haystack as $value) {
			if ($value == $needle) {
				return true;
			} else if (is_array($value) && self::arrayDeepSearch($needle, $value)) {
				return true;
			}
		}
		return false;
	}

}