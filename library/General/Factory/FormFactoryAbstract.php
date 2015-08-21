<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 03/07/2015
 * Time: 11:27
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