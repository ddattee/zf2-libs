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
use General\Filter\Url;

class UrlTest extends AbstractTest
{
    /**
     * Data
     *
     * @var array
     */
    protected $data = [
       'ÂÂÔisioqpPO &&-B123'     => 'aaoisioqppo-andand-b123',
       'My malformed domain'     => 'my-malformed-domain',
       'My malformed domain.com' => 'my-malformed-domain.com',
    ];

    /**
     * Test filter
     */
    public function testUrlConversion()
    {
        $filter = new Url();

        foreach($this->data as $custom => $str) {
            $this->assertEquals($str, $filter->filter($custom), "'$custom' should have become $str");
        }
    }
}
