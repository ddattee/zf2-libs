<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 30/06/2015
 * Time: 11:20
 */

namespace General\Utils;


class Date
{

	/**
	 * Date format converter using PHP DateTime format
	 *
	 * @param string $date
	 * @param string $format_out
	 * @param string $format_in
	 * @return string
	 */
	public static function dateTimeConvert($date, $format_out = 'd/m/Y H:i:s', $format_in = 'Y-m-d H:i:s')
	{
		$tmp = DateTime::createFromFormat($format_in, $date);
		if ($tmp)
			return $tmp->format($format_out);
		return $date;
	}

	/**
	 * Convert FR formated date to EN format
	 *
	 * @param string $date Formated d/m/Y
	 * @return string
	 */
	public static function dateFr2En($date)
	{
		return self::dateTimeConvert($date, 'Y-m-d', 'd/m/Y');
	}

	/**
	 * Convert EN formated date to FR format
	 *
	 * @param string $date Formated Y-m-d
	 * @return string
	 */
	public static function dateEn2Fr($date)
	{
		return self::dateTimeConvert($date, 'd/m/Y', 'Y-m-d');
	}

	/**
	 * Convert FR formated date to EN format
	 *
	 * @param string $date Formated d/m/Y H:i:s
	 * @return string
	 */
	public static function dateTimeFr2En($datetime)
	{
		return self::dateTimeConvert($datetime, 'Y-m-d H:i:s', 'd/m/Y H:i:s');
	}

	/**
	 * Convert EN formated date to FR format
	 *
	 * @param string $date Formated Y-m-d H:i:s
	 * @return string
	 */
	public static function dateTimeEn2Fr($datetime)
	{
		return self::dateTimeConvert($datetime);
	}
}