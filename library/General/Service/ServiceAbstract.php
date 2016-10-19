<?php
/**
 * Service abstract add mapper autoload functionality and service accessor
 *
 * @category  General
 * @package   General\Ogone
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Service;

use General\Mapper\MapperAbstract;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceAbstract implements AbstractFactoryInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $mapper;

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->loadMapper();
        return $this;
    }

    /**
     * Load mapper into the service
     * @param MapperAbstract $mapper
     */
    public function setMapper(MapperAbstract $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * Return the mapper
     * @return MapperAbstract
     */
    public function getMapper()
    {
        return $this->mapper;
    }

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
        return (is_subclass_of($requestedName, '\General\Service\ServiceAbstract'));
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

    /**
     * Load mapper into the service if one is found
     */
    protected function loadMapper()
    {
        $classname = get_class($this);
        $match = array();
        if (preg_match('/(.+)Service/', $classname, $match)
            && class_exists(str_replace('Service', 'Mapper', $match[1]) . 'Mapper')
        ) {
            $mapperclass = str_replace('Service', 'Mapper', $match[1]) . 'Mapper';
            $this->setMapper($this->getServiceLocator()->get($mapperclass));
        }
    }
}
