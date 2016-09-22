<?php

namespace General\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * DateTime hydration strategy
 */
class DatetimeStrategy implements StrategyInterface
{
    /**
     * Convert date time to string
     *
     * @param \DateTime $value Date value
     *
     * @return mixed
     */
    public function extract($value)
    {
        return $value->format('Y-m-d H:i:s');
    }

    /**
     * Convert string to DateTime
     *
     * @param string $value Date
     *
     * @return \DateTime
     */
    public function hydrate($value)
    {
        return ($value instanceof \DateTime ? $value : new \DateTime($value));
    }
}
