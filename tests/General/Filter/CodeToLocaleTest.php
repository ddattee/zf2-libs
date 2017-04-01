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
use General\Filter\CodeToLocale;

class CodeToLocaleTest extends AbstractTest
{
    /**
     * Locale data to test
     *
     * @var array
     */
    protected $locale = [
        'fr' => 'fr_FR',
        'en' => 'en_US',
        'de' => 'de_DE',
        'ar' => 'ar_JO',
        'cs' => 'cs_CZ',
        'de' => 'de_DE',
        'es' => 'es_ES',
        'it' => 'it_IT',
        'ja' => 'ja_JP',
        'nb' => 'nb_NO',
        'nl' => 'nl_NL',
        'pl' => 'pl_PL',
        'ru' => 'ru_RU',
        'sl' => 'sl_SI',
        'tr' => 'tr_TR',
        'uk' => 'uk_UA',
        'zh' => 'zh_CN',
    ];

    /**
     * Wrong locale
     *
     * @var array
     */
    protected $wrongLocale = [
        'sdf'      => 'zer',
        'DS'       => 'FQS',
        'qsdQD'    => 'qsd',
        'qsd_QD'   => '321',
        'qsd_QQsd' => '321-qsd',
        'qsd_Q65'  => '321_qsdsdf',
    ];

    /**
     * Test good filter
     */
    public function testGoodFiltering()
    {
        $filter = new CodeToLocale();
        foreach($this->locale as $short => $long) {
            $this->assertEquals($filter->filter($short), $long);
        }
    }

    /**
     * Test wrong filter
     */
    public function testBadFiltering()
    {
        $filter = new CodeToLocale();
        foreach($this->wrongLocale as $short => $long) {
            $this->assertNotEquals($filter->filter($short), $long);
        }
    }
}