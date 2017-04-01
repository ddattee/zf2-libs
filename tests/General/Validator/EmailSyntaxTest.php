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
use General\Validator\EmailSyntaxe;

class EmailSyntaxTest extends AbstractTest
{
    /**
     * Good emails
     *
     * @var array
     */
    protected $goodEmails = [
        'abcdef@abdcfr.sdf',
        'qsdqsd.abcdef@abdcfr.sdf',
        'qsdqsd-abcdef@abdcfr.sdf',
        'qsdqsd-abcdef@abdcfr.sdfsdf-qsd.sdf',
        'abcdef@abdcfr-qsdqs.sdfqsd',
        'azaze.abcdef@abdcfr-qsdqs.sdfqsd',
    ];

    /**
     * Bad emails
     *
     * @var array
     */
    protected $badEmails = [
        'qsdqsdqsd',
        '65654',
        '65654@987987',
        '65654@987987.65654',
        'qsdqsdqsd@qsdqsd',
        'qsdqsdqsd@654',
        'qsdqsdqsd@qsdqsd.321',
        'qsdqsdqsd@qsdqsd.qs321',
    ];

    /**
     * Test valid email syntax
     */
    public function testGoodValidation()
    {
        $validator = new EmailSyntaxe();

        foreach($this->goodEmails as $email) {
            $this->assertTrue($validator->isValid($email), 'Email ' . $email . ' is not valid');
        }
    }

    /**
     * Test valid email syntax
     */
    public function testWrongValidation()
    {
        $validator = new EmailSyntaxe();

        foreach($this->badEmails as $email) {
            $this->assertFalse($validator->isValid($email), 'Email ' . $email . ' is valid');
        }
    }
}
