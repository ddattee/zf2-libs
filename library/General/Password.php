<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 29/06/2015
 * Time: 15:01
 */

namespace General;

/**
 * Class Password
 *
 * @package General
 */
class Password
{
    /**
     * Generate random password with letters (upper and lower), number and some special char
     *
     * @return string
     */
    public static function generate() {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            . '0123456789'
            . '@!$€');
        shuffle($seed);
        $rand = '';
        foreach (array_rand($seed, 10) as $k) {
            $rand .= $seed[$k];
        }

        return $rand;
    }
}