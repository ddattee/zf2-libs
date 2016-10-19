<?php
/**
 * Libs Module declaration to be able to have a default config
 *
 * @category  Libs
 * @package   Libs
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace Libs;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface
{

    /**
     * Get autoload config
     *
     * @see \Zend\ModuleManager\Feature\AutoloaderProviderInterface::getAutoloaderConfig()
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array();
    }

    /**
     * Get config
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . DIRECTORY_SEPARATOR . '/../../config/module.config.php';
    }
}
