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

use Tests\AbstractTest;
use General\Utils\Password;

class PasswordTest extends AbstractTest
{
    /**
     * Test for password generation randomness
     */
    public function testPasswordGenerationRandomness()
    {
        $passwords = [];
        $password = new Password();
        for ($i = 0; $i <= 10000; $i++) {
            $newPass = $password->generate();
            $this->assertGreaterThan(7, strlen($newPass));
            $this->assertNotContains($newPass, $passwords);
            $passwords[] = $newPass;
        }
    }
}
