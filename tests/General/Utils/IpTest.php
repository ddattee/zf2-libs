<?php
/**
 * Libs model
 *
 * @category  Tests\General
 * @package   Tests\General\Utils
 * @author    Difidus
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace Tests\General\Utils;

use General\Utils\Ip;
use Tests\AbstractTest;

class IpTest extends AbstractTest
{
    /**
     * Local IPS
     *
     * @var array
     */
    protected $localIps = [
        '127.0.0.1',
        '10.0.3.0',
        '10.255.3.15',
        '10.255.3.254',
        '172.16.35.125',
        '169.254.2.156',
        '192.168.165.32',
        '192.168.165.254',
        '224.10.184.37',
    ];

    protected $notLocalIps = [
        '193.165.241.22',
        '176.158.132.67',
        '120.253.32.151',
        '255.255.255.254',
        '101.165.251.32',
        '203.1.1.1',
    ];

    /**
     * Test for local IPs
     */
    public function testCorrectLocalIp()
    {
        $validator = new Ip();
        foreach ($this->localIps as $ip) {
            $this->assertTrue($validator->isLocal($ip), $ip . ' is not a local IP.');
        }
    }

    /**
     * Test for not local IPs
     */
    public function testNotLocalIp()
    {
        $validator = new Ip();
        foreach ($this->notLocalIps as $ip) {
            $this->assertFalse($validator->isLocal($ip), $ip . ' is a local IP.');
        }
    }
}
