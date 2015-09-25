<?php

/**
 * Description of DomainName
 *
 * @author ddattee
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