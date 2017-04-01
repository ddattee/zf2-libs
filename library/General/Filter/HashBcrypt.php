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

    protected $encryptor;

    public function __construct()
    {
        $this->encryptor = new Bcrypt();
    }

    /**
     * Returns the string hashed with bcrypt
     *
     * @param  string $value
     *
     * @return string
     */
    public function filter($value)
    {
        return (string) $this->encryptor->create($value);
    }

    /**
     * Set encrypting salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->encryptor->setSalt((string) $salt);
    }
}
