<?php

namespace CMPayments\IBAN\Test;

use PHPUnit_Framework_TestCase;
use CMPayments\IBAN;

class IBANValidateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var IBAN
     */
    private $iban;

    public function setUp()
    {
        $this->iban = new IBAN('NL58ABNA0000000001');
    }

    /**
     * @param IBAN $iban
     * @dataProvider provideValidIban
     */
    public function testIbanValidation(IBAN $iban)
    {
        $this->assertTrue($iban->validate(), "{$iban} => validation failed");
    }

    /**
     * @param IBAN $iban
     * @dataProvider provideInvalidIban
     */
    public function testIbanValidationFailed(IBAN $iban)
    {
        $this->assertFalse($iban->validate(), "{$iban} => validation failed");
    }

    /**
     * @param IBAN $iban
     * @dataProvider provideValidIban
     */
    public function testIbanCheck(IBAN $iban)
    {
        $this->assertNull($iban->check(), "{$iban} => check failed");
    }

    /**
     * @expectedException \CMPayments\Exception\InvalidCountry
     * @expectedExceptionMessage IBAN (BK561910000001234383) country code not valid or not supported
     */
    public function testIbanCheckInvalidCountry()
    {
        (new IBAN('BK561910000001234383'))->check();
    }

    /**
     * @expectedException \CMPayments\Exception\InvalidLength
     * @expectedExceptionMessage IBAN (AL472121100900000002356987410) length is invalid
     */
    public function testIbanCheckInvalidLength()
    {
        (new IBAN('AL472121100900000002356987410'))->check();
    }

    /**
     * @expectedException \CMPayments\Exception\InvalidFormat
     * @expectedExceptionMessage IBAN (CZA50800000K192000145399) format is invalid
     */
    public function testIbanCheckInvalidFormat()
    {
        (new IBAN('CZa50800000k192000145399'))->check();
    }

    /**
     * @expectedException \CMPayments\Exception\InvalidChecksum
     * @expectedExceptionMessage IBAN (AA00000000000000) checksum is invalid
     */
    public function testIbanCheckInvalidChecksum()
    {

        (new IBAN('AA00000000000000'))->check();
    }

    /**
     * @dataProvider provideSanitizeIban
     */
    public function testIbanSanitation($iban)
    {
        $this->assertTrue((new IBAN($iban))->validate(), "{$iban} => failed to sanitize");
    }

    public function testGetCountryCode()
    {
        $this->assertEquals('NL', $this->iban->getCountryCode());
    }

    public function testGetChecksum()
    {
        $this->assertEquals('58', $this->iban->getChecksum());
    }

    public function testGetInstituteIdentification()
    {
        $this->assertEquals('ABNA', $this->iban->getInstituteIdentification());
    }

    public function testGetBankAccountNumber()
    {
        $this->assertEquals('0000000001', $this->iban->getBankAccountNumber());
    }

    public function testIbanFormatter()
    {
        $this->assertEquals('NL58 ABNA 0000 0000 01', $this->iban->format());
    }


    public function provideValidIban()
    {
        return array_map(
            function ($iban) {
                return [new IBAN($iban)];

            }, include __DIR__ . '/data/ValidIbans.php'
        );
    }

    public function provideInvalidIban()
    {
        return array_map(
            function ($iban) {
                return [new IBAN($iban)];
            }, include __DIR__ . '/data/InvalidIbans.php'
        );
    }

    public function provideSanitizeIban()
    {
        return [
            ['NL 58 ABNA 0000 0000 01'],
            ['NL-58-ABNA-0000-0000-01'],
            ['{NL}[58](ABNA)<0000>"0000"`01`'],
            ['!@NL#$58%^ABNA&*0000;|0000,.01/:']
        ];
    }
}
