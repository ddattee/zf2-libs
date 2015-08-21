<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 18/06/2015
 * Time: 15:39
 */

namespace General\Filter;


use Zend\Filter\FilterInterface;

class UrlToLocale implements FilterInterface
{
    private $_default_locale = array(
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
        'zh' => 'zh_CN'
    );

    /**
     * Return the two letter url corresponding locale
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        return (array_key_exists($value, $this->_default_locale) ? $this->_default_locale[$value] : $value);
    }

}