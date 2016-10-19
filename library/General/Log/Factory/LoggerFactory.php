<?php
/**
 * Logger factory to add debug logger into data/log/debug.log
 *
 * @category  General
 * @package   General\Log\Factory
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Log\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

/**
 * Created by PhpStorm.
 * User: Difidus
 * Date: 08/10/2016
 * Time: 17:43
 */
class LoggerFactory implements FactoryInterface
{
    /**
     * Create logger
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $logDir = PRIVATE_PATH . '/log/';
        $logFile = $logDir . 'debug.log';
        is_dir($logDir) ? : @mkdir($logDir, 0755, true);
        file_exists($logFile) ? : @touch($logFile);
        $logger = new Logger();
        $writer = new Stream($logFile);
        $logger->addWriter($writer);
        return $logger;
    }
}
