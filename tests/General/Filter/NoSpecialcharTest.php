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
use General\Filter\NoSpecialchar;

class NoSpecialcharTest extends AbstractTest
{
    /**
     * Data
     *
     * @var array
     */
    protected $data = [
        'À'     => 'a',
        'Á'     => 'a',
        'Â'     => 'a',
        'Ã'     => 'a',
        'Ä'     => 'a',
        'Å'     => 'a',
        'à'     => 'a',
        'á'     => 'a',
        'â'     => 'a',
        'ã'     => 'a',
        'ä'     => 'a',
        'å'     => 'a',
        'Ò'     => 'o',
        'Ó'     => 'o',
        'Ô'     => 'o',
        'Õ'     => 'o',
        'Ö'     => 'o',
        'Ø'     => 'o',
        'ò'     => 'o',
        'ó'     => 'o',
        'ô'     => 'o',
        'õ'     => 'o',
        'ö'     => 'o',
        'ø'     => 'o',
        'È'     => 'e',
        'É'     => 'e',
        'Ê'     => 'e',
        'Ë'     => 'e',
        'è'     => 'e',
        'é'     => 'e',
        'ê'     => 'e',
        'ë'     => 'e',
        'Ç'     => 'c',
        'ç'     => 'c',
        'Ì'     => 'i',
        'Í'     => 'i',
        'Î'     => 'i',
        'Ï'     => 'i',
        'ì'     => 'i',
        'í'     => 'i',
        'î'     => 'i',
        'ï'     => 'i',
        'Ù'     => 'u',
        'Ú'     => 'u',
        'Û'     => 'u',
        'Ü'     => 'u',
        'ù'     => 'u',
        'ú'     => 'u',
        'û'     => 'u',
        'ü'     => 'u',
        'ÿ'     => 'y',
        'Ñ'     => 'n',
        'ñ'     => 'n',
        ' '     => '-',
        '?'     => '',
        '!'     => '',
        ','     => '',
        ':'     => '',
        "'"     => '-',
        '&'     => 'and',
        '('     => '',
        ')'     => '',
        '\\'    => '-',
        '/'     => '-',
        '--'    => '-',
        '-----' => '-',
    ];

    /**
     * Test filter
     */
    public function testCharReplacement()
    {
        $filter = new NoSpecialchar();

        foreach($this->data as $custom => $char) {
            $this->assertEquals($filter->filter($custom), $char, "'$custom' should have become $char");
        }
    }
}
