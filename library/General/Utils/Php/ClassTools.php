<?php
/**
 * Class utilities functions
 *
 * @category  General
 * @package   General\Utils\Php
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Utils\Php;

class ClassTools
{
    /**
     * Return class doc blocks found in the give file.
     * @param string $class
     * @return string
     */
    public static function getClassComments($class)
    {
        $rc = new \ReflectionClass($class);
        return $rc->getDocComment();
    }

    /**
     * Return method doc blocks found in the give file.
     * @param string $class
     * @param string $method
     * @return string
     */
    public static function getMethodComments($class, $method)
    {
        $rc = new \ReflectionMethod($class, $method);
        return $rc->getDocComment();
    }

    /**
     * Return method param ReflectionParameter
     * @param string $class
     * @param string $method
     * @param string $param
     * @return \ReflectionParameter
     */
    public static function getMethodParam($class, $method, $param)
    {
        return new \ReflectionParameter(array($class, $method), $param);
    }
}
