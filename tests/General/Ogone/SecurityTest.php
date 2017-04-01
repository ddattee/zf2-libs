<?php
/**
 * Libs Ogone test
 *
 * @category  Tests\General
 * @package   Tests\General\Ogone
 * @author    Difidus
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace Tests\General\Ogone;

use General\Ogone\ParamException;
use Tests\AbstractTest;
use General\Ogone\Security;

/**
 * Class SecurityTest
 *
 * Data from :
 * SHA IN REF  : https://payment-services.ingenico.com/fr/fr/ogone/support/guides/integration%20guides/e-commerce/security-pre-payment-check#shainsignature
 * SHA OUT REF : https://payment-services.ingenico.com/fr/fr/ogone/support/guides/integration%20guides/e-commerce/transaction-feedback#redirectionwithdatabaseupdate
 *
 * @package Tests\General\Ogone
 */
class SecurityTest extends AbstractTest
{
    /**
     * @var array
     */
    protected $dataShaIn = [
        'PSPID'    => 'MyPSPID',
        'LANGUAGE' => 'en_US',
        'ORDERID'  => 1234,
        'AMOUNT'   => 1500,
        'CURRENCY' => 'EUR',
    ];

    /**
     * @var array
     */
    protected $dataShaOut = [
        'ACCEPTANCE' => 1234,
        'amount'     => 15,
        'BRAND'      => 'VISA',
        'CARDNO'     => 'XXXXXXXXXXXX1111',
        'currency'   => 'EUR',
        'NCERROR'    => 0,
        'orderID'    => 12,
        'PAYID'      => 32100123,
        'PM'         => 'CreditCard',
        'STATUS'     => 9,
    ];

    /**
     * Sha in that should be generated
     *
     * @var string
     */
    protected $shaIn  = 'F4CC376CD7A834D997B91598FA747825A238BE0A';

    /**
     * Sha out that should be generated
     *
     * @var string
     */
    protected $shaOut = '209113288F93A9AB8E474EA78D899AFDBB874355';

    /**
     * Secret to use to generate sha sign
     *
     * @var string
     */
    protected $secret = 'Mysecretsig1875!?';

    /**
     * Test correct validation
     */
    public function testCorrectValidation()
    {
        $security = new Security();
        $this->assertTrue($security->isValidShasign('s3d2fg98er5l65jk46', 's3d2fg98er5l65jk46'));
    }

    /**
     * Test correct validation
     */
    public function testBadValidation()
    {
        $security = new Security();
        $this->assertFalse($security->isValidShasign('s3d2fg98er5l65jk46', '98dfghd6f5gh32'));
    }

    /**
     * Test sha out generation
     */
    public function testParamValidation()
    {
        $security = new Security();

        $this->assertTrue($security->isValidParam('PARAMPLUS', 'in'));
        $this->assertFalse($security->isValidParam('AAVADDRESS', 'in'));

        $this->assertTrue($security->isValidParam('AAVADDRESS', 'out'));
        $this->assertFalse($security->isValidParam('PARAMPLUS', 'out'));
    }

    /**
     * Test sha generation with wrong param throw exception
     */
    public function testWrongParamInThrowException()
    {
        $security = new Security();

        $this->setExpectedException(ParamException::class);
        $security->generateShaSign(['AAVADDRESS' => 'test'], $this->secret);
    }

    /**
     * Test sha generation with wrong param throw exception
     */
    public function testWrongParamOutThrowException()
    {
        $security = new Security();

        $this->setExpectedException(ParamException::class);
        $security->generateShaSign(['PARAMPLUS' => 'test'], $this->secret, 'out');
    }

    /**
     * Test sha in generation
     */
    public function testShaInGeneration()
    {
        $security = new Security();
        $shasign  = $security->generateShaSign($this->dataShaIn, $this->secret);

        $this->assertEquals($this->shaIn, $shasign);
    }

    /**
     * Test sha out generation
     */
    public function testShaOutGeneration()
    {
        $security = new Security();
        $shasign  = $security->generateShaSign($this->dataShaOut, $this->secret, 'out');

        $this->assertEquals($this->shaOut, $shasign);
    }
}
