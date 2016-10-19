<?php
/**
 * Extract the DNS part of a URL
 *
 * @category  General
 * @package   General\Filter
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Filter;

use Zend\Filter\FilterInterface;

class DomainName implements FilterInterface
{
    /**
     * Returns the string $value, removing all but the domaine name (with sub-domain)
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        $vals_arr = explode('/', $value);
        $res = '';
        if (preg_match('#http#', $vals_arr[0])) {
            $res = $vals_arr[2];
        } else {
            $res = $vals_arr[0];
        }

        return (string)$res;
    }
}
