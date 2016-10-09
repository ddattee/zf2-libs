<?php

namespace General\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Date hydration strategy
 */
class FrDateStrategy implements StrategyInterface
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
        return $value->format('d/m/Y');
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
