<?php
/**
 * Replace any special chan in string and cast it to lower
 *
 * @category  General
 * @package   General\Filter
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Filter;

use Zend\Filter\FilterInterface;
use General\Filter\NoSpecialchar;

class Url implements FilterInterface
{

    /**
     * Returns the string $value, removing all accents, on lower case and remove special caracteres
     *
     * @param  string $chaine Value to filter
     *
     * @return string
     */
    public function filter($chaine)
    {
        $char = new NoSpecialchar();
        return strtolower($char->filter($chaine));
    }
}
