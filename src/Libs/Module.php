<?php

namespace Libs;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements
	ConfigProviderInterface,
	AutoloaderProviderInterface
{

	/**
	 * @see \Zend\ModuleManager\Feature\AutoloaderProviderInterface::getAutoloaderConfig()
	 * @return array
	 */
	public function getAutoloaderConfig()
	{
		return array();
	}

	/**
	 * @return array
	 */
	public function getConfig()
	{
		return include __DIR__ . DIRECTORY_SEPARATOR . '/../../config/module.config.php';
	}
}