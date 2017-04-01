<?php
/**
 * Password generator
 *
 * @category  General
 * @package   General\Utils
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Utils;

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
    public function generate() {
        $rand   = '';
        $length = rand(8, 12);
        $seed   = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            . '0123456789'
            . '@!$€');
        shuffle($seed);
        foreach (array_rand($seed, $length) as $k) {
            $rand .= $seed[$k];
        }

        return $rand;
    }
}
