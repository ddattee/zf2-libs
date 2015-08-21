<?php

/**
 * Description of General_Filter_DomainName
 *
 * @author ddattee
 */
namespace General\Filter;

use Zend\Filter\FilterInterface;

class Url implements FilterInterface
{

	/**
	 * Returns the string $value, removing all accents, on lower case and remove special caracteres
	 *
	 * @param  string $value
	 * @return string
	 */
	public function filter($chaine)
	{

		$char = new General_Filter_NoSpecialchar();
		return strtolower($char->filter($chaine));
	}

}