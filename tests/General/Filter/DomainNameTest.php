<?php
/**
 * Tools module
 *
 * @category  Tools
 * @package   Tools
 * @author    Difidus
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace Tests\General\Filter;

use Tests\AbstractTest;
use General\Filter\DomainName;

class DomainNameTest extends AbstractTest
{
    /**
     * Valid data
     *
     * @var array
     */
    protected $valid = [
        'http://qsdqsd.qsdqsd/uri'         => 'qsdqsd.qsdqsd',
        'http://qsdqsd.qsdqsd/uri/oiu/poi' => 'qsdqsd.qsdqsd',
        'http://qsd.sd.qsdqsd/uri/oiu/poi' => 'qsd.sd.qsdqsd',
        'https://zerzer.zerzer/uri'        => 'zerzer.zerzer',
        'http://zae.zerzer.zerzer/uri'     => 'zae.zerzer.zerzer',
        'http://zae.ze-rzer.zerzer/uri'    => 'zae.ze-rzer.zerzer',
        'http://zae.ze-321.zerzer/uri'     => 'zae.ze-321.zerzer',
    ];

    /**
     * Wrong data
     *
     * @var array
     */
    protected $wrong = [
        'http://qsdqsd.qsdqsd/uri'         => 'http://qsdqsd.qsdqsd',
        'https://zerzer.zerzer/uri'        => 'https://zerzer.zerzer',
        'http://zae.zerzer.zerzer/uri'     => 'zae.zerzer.zerzer/uri',
        'http://qsdqsd.qsdqsd/uri/oiu/poi' => 'uri/oiu/poi',
        'http://qsd.sd.qsdqsd/uri/oiu/poi' => 'oiu/poi',
        'http://zae.ze-rzer.zerzer/uri'    => 'uri',
        'http://zae.ze-rze.zerzer/uri'     => 'http://uri',
        'http://zae.ze-321.zerzer/uri'     => 'ze-321.zerzer',
        'http://zae.ze-3214.zerzer/uri'    => 'ze-3214.zerzer/uri',
        'http://zae.ze-32.zerzer/uri'      => 'q6s5d4',
    ];

    /**
     * Test good filter
     */
    public function testGoodFiltering()
    {
        $filter = new DomainName();
        foreach($this->valid as $url => $domain) {
            $this->assertEquals($filter->filter($url), $domain);
        }
    }

    /**
     * Test wrong filter
     */
    public function testBadFiltering()
    {
        $filter = new DomainName();
        foreach($this->wrong as $url => $domain) {
            $this->assertNotEquals($filter->filter($url), $domain);
        }
    }
}