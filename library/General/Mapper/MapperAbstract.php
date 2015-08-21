<?php
/**
 * Created by PhpStorm.
 * User: Difidus
 * Date: 19/08/2015
 * Time: 23:03
 */

namespace General\Mapper;


use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class MapperAbstract implements AbstractFactoryInterface, ServiceLocatorAwareInterface
{
	use ServiceLocatorAwareTrait;

	/**
	 * Determine if we can create a service with name
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @param $name
	 * @param $requestedName
	 * @return bool
	 */
	public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
	{
		return (is_subclass_of($requestedName, '\General\Mapper\MapperAbstract'));
	}

	/**
	 * Create service with name
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @param $name
	 * @param $requestedName
	 * @return mixed
	 */
	public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
	{
		$service = new $requestedName();
		$service->setServiceLocator($serviceLocator);
		return $service;
	}


}