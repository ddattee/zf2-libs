<?php

/**
 * Description of General_Filter_HostingCat
 *
 * @author ddattee
 */

namespace General\Filter;


use Zend\Filter\FilterInterface;

class HostingCat implements FilterInterface
{

	/**
	 * Returns the string $value, removing all but the domaine name (with sub-domain
	 *
	 * @param  string $value
	 * @return string
	 */
	public function filter($value)
	{
		$value = preg_replace(array('/[^0-9e*]/', '/\*/'), array('', 'e'), $value);
		return (string)$value;
	}

}
