<?php
/**
 * REST client factory
 *
 * @category  Rest
 * @package   Rest\Factory
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace Rest\Factory;


use Rest\Client;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ClientFactoryAbstract implements AbstractFactoryInterface
{

    /**
     * @inheritdoc
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return ('Client' === $name || is_subclass_of($requestedName, '\Rest\Client'));
    }

    /**
     * @inheritdoc
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return new $requestedName($serviceLocator->get('config')['rest']);
    }
}