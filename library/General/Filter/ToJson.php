<?php

/**
 * Description of General_Filter_DomainName
 *
 * @author ddattee
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