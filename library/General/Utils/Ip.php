<?php
/**
 * IP utilities functions
 *
 * @category  General
 * @package   General\Utils
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Utils;

class Ip
{
    /**
     * Check if an IP is from a local network or not
     * @param string $ip
     * @return boolean
     */
    public static function isLocal($ip)
    {
        $local_ips = array(
            '167772160' => 184549375, /*    10.0.0.0 -  10.255.255.255 */
            '3232235520' => 3232301055, /* 192.168.0.0 - 192.168.255.255 */
            '2130706432' => 2147483647, /*   127.0.0.0 - 127.255.255.255 */
            '2851995648' => 2852061183, /* 169.254.0.0 - 169.254.255.255 */
            '2886729728' => 2887778303, /*  172.16.0.0 -  172.31.255.255 */
            '3758096384' => 4026531839, /*   224.0.0.0 - 239.255.255.255 */
        );

        $ip_long = sprintf('%u', ip2long($ip));

        foreach ($local_ips as $ip_start => $ip_end) {
            if (($ip_long >= $ip_start) && ($ip_long <= $ip_end)) {
                return true;
            }
        }
        return false;
    }
}
