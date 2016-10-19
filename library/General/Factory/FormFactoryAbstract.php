<?php
/**
 * Form factory abstract us to create General\Form
 *
 * @category  General
 * @package   General\Factory
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Factory;


use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FormFactoryAbstract implements AbstractFactoryInterface
{

    /**
     * @inheritdoc
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return ('Form' === $name || is_subclass_of($requestedName, '\General\Form'));
    }

    /**
     * @inheritdoc
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return new $requestedName($serviceLocator);
    }

}