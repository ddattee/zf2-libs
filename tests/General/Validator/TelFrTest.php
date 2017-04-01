<?php
/**
 * Libs tests
 *
 * @category  Tests\General
 * @package   Tests\General\Validator
 * @author    Difidus
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace Tests\General\Validator;

use Tests\AbstractTest;
use General\Validator\TelFr;

class TelFrTest extends AbstractTest
{
    /**
     * Good phone numbers
     *
     * @var array
     */
    protected $goodNumbers = [
        '+33 1 23 21 65 32',
        '+33 6 23 21 65 32',
        '+33.6-23 21-65.32',
        '0033 6 23 21 65 32',
        '01 23 21 65 32',
        '06 23 21 65 32',
        '01-23-21-65-32',
        '01.23.21.65.32',
    ];

    /**
     * Bad phone numbers
     *
     * @var array
     */
    protected $badNumbers = [
        '+33 01 23 21 65 32',
        '+33 06 23 21 65 32',
        '0033 06 23 21 65 32',
        '1 23 21 65 32',
        '6 23 21 65 32',
        '1-23-21-65-32',
        '6.23.21.65.32',
        '6.23-21 65.32',
    ];

    /**
     * Test valid french numbers
     */
    public function testGoodValidation()
    {
        $validator = new TelFr();

        foreach($this->goodNumbers as $number) {
            $this->assertTrue($validator->isValid($number), 'Number ' . $number . ' is not valid');
        }
    }

    /**
     * Test valid french numbers
     */
    public function testWrongValidation()
    {
        $validator = new TelFr();

        foreach($this->badNumbers as $number) {
            $this->assertFalse($validator->isValid($number), 'Number ' . $number . ' is valid');
        }
    }
}
