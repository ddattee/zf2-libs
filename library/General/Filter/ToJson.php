<?php
/**
 * Format given value into JSON
 *
 * @category  General
 * @package   General\Filter
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Filter;

use Zend\Filter\FilterInterface;

class ToJson implements FilterInterface
{
    /**
     * Returns the string $value, removing all but the domaine name (with sub-domain
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        return (string)json_encode($value);
    }
}
