<?php
/**
 * Encrypt a string with BCrypt
 *
 * @category  General
 * @package   General\Filter
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Filter;

use Zend\Crypt\Password\Bcrypt;
use Zend\Filter\FilterInterface;

class HashBcrypt implements FilterInterface
{
    /**
     * Returns the string hashed with bcrypt
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        $bcrypt = new Bcrypt();
        return (string)$bcrypt->create($value);
    }
}
