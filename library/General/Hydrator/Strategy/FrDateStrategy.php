<?php
/**
 * French date formated hydration strategy
 *
 * @category  General
 * @package   General\Hydrator\Strategy
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

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
        return ($value instanceof \DateTime ? $value : \DateTime::createFromFormat('d/m/Y', $value));
    }
}
