<?php

namespace General\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

/**
 * DateTime hydration strategy
 */
class DatetimeStrategy implements StrategyInterface
{
	public function extract($value)
	{
		return $value;
	}

	public function hydrate($value)
	{
		return ($value instanceof \DateTime ? $value : new \DateTime($value));
	}
}
