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
use Zend\Crypt\Password\Bcrypt;
use General\Filter\HashBcrypt;

class HashBcryptTest extends AbstractTest
{
    /**
     * Salt for encrypt
     *
     * @var string
     */
    protected $salt = 'qsd3f216984@ghdç876(';

    /**
     * Valid data
     *
     * @var array
     */
    protected $data = [
        'qsdqsdqsd',
        '321654654',
        'qsdqsdqsd23321',
        'qsdqs#dqsd23321',
        'qsdqs_dqsd23321',
        'qsdqsçàdqsd23321',
        'qsdqs{]dqsd23321',
        'qsdqs"dqsd23321',
        'qsdqsdqsd-23321',
        'qsdqsdqsd@23321',
        'qsdqsdq.sd@23321',
    ];

    /**
     * Test good filter
     */
    public function testGoodFiltering()
    {
        $bcrypt = new Bcrypt();
        $filter = new HashBcrypt();

        $bcrypt->setSalt($this->salt);
        $filter->setSalt($this->salt);

        foreach($this->data as $str) {
            $this->assertEquals($filter->filter($str), (string) $bcrypt->create($str));
        }
    }

    /**
     * Test good filter
     */
    public function testBadFiltering()
    {
        $bcrypt = new Bcrypt();
        $filter = new HashBcrypt();

        $bcrypt->setSalt('32q1sd987jnàç76qcpo#qlytp');
        $filter->setSalt($this->salt);

        foreach($this->data as $str) {
            $this->assertNotEquals($filter->filter($str), (string) $bcrypt->create($str));
        }
    }
}
