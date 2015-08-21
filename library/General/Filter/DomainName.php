<?php

/**
 * Description of DomainName
 *
 * @author ddattee
 */

namespace General\Filter;

use Zend\Filter\FilterInterface;

class DomainName implements FilterInterface
{
	/**
	 * Returns the string $value, removing all but the domaine name (with sub-domain
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