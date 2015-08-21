<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 01/07/2015
 * Time: 12:15
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