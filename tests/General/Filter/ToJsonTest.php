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
use General\Filter\ToJson;

class ToJsonTest extends AbstractTest
{
    /**
     * Data
     *
     * @var array
     */
    protected $data = [];

    /**
     * Test filter
     */
    public function testUrlConversion()
    {
        $filter = new ToJson();

        foreach($this->getData() as $expected => $raw) {
            $this->assertEquals($expected, $filter->filter($raw), var_export($raw, true) . " should have become $expected");
        }
    }

    /**
     * Fill up data to test
     *
     * @return array
     */
    public function getData()
    {
        if (empty($this->data)) {
            $obj = new \stdClass();
            $obj->aa = 'AA';
            $obj->bb = 211;
            $obj->b123 = 'ui';

            $this->data = [
               '"sdfsdfsdfsdf"'                   => 'sdfsdfsdfsdf',
               '["aa","bb",123]'                  => ['aa', 'bb', 123],
               '{"aa":"AA","bb":211,"123":"ui"}'  => ['aa' => 'AA', 'bb' => 211, 123 => 'ui'],
               '{"aa":"AA","bb":211,"123":"uis"}' => (object) ['aa' => 'AA', 'bb' => 211, 123 => 'uis'],
               '{"aa":"AA","bb":211,"b123":"ui"}' => $obj,
            ];
        }

        return $this->data;
    }
}
