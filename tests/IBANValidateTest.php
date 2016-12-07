<?php

namespace CMPayments\IBAN\Test;

use PHPUnit_Framework_TestCase;
use CMPayments\IBAN;

class IBANValidateTest extends PHPUnit_Framework_TestCase
{
    const IBAN_TEST_NL = 'NL58ABNA0000000001';
    const IBAN_TEST_SANITIZE1 = 'NL 58 ABNA 0000 0000 01';
    const IBAN_TEST_SANITIZE2 = 'NL-58-ABNA-0000-0000-01';
    const IBAN_TEST_SANITIZE3 = '{NL}[58](ABNA)<0000>"0000"`01`';
    const IBAN_TEST_SANITIZE4 = '!@NL#$58%^ABNA&*0000;|0000,.01/:';

    public function testValidIbans()
    {
        $validIbans = require __DIR__ . '/data/ValidIbans.php';
        foreach ($validIbans as $iban) {
            $this->assertTrue((new IBAN($iban))->validate($error), "{$iban} => " . $error);
        }
    }

    public function testInvalidIbans()
    {
        $invalidIbans = require __DIR__ . '/data/InvalidIbans.php';
        foreach ($invalidIbans as $iban) {
            $this->assertFalse((new IBAN($iban))->validate($error), "{$iban} should not be valid");
        }
    }

    public function testIbanSanitation()
    {
        $ibans = [
            static::IBAN_TEST_SANITIZE1,
            static::IBAN_TEST_SANITIZE2,
            static::IBAN_TEST_SANITIZE3,
            static::IBAN_TEST_SANITIZE4
        ];
        foreach ($ibans as $iban) {
            $this->assertTrue((new IBAN($iban))->validate(), "{$iban} => failed to sanitize");
        }
    }

    public function testGetCountryCode()
    {
        $this->assertEquals('NL', (new IBAN(static::IBAN_TEST_NL))->getCountryCode());
    }

    public function testGetChecksum()
    {
        $this->assertEquals('58', (new IBAN(static::IBAN_TEST_NL))->getChecksum());
    }

    public function testGetInstituteIdentification()
    {
        $this->assertEquals('ABNA', (new IBAN(static::IBAN_TEST_NL))->getInstituteIdentification());
    }

    public function testGetBankAccountNumber()
    {
        $this->assertEquals('0000000001', (new IBAN(static::IBAN_TEST_NL))->getBankAccountNumber());
    }

    public function testIbanFormatter()
    {
        $this->assertEquals('NL58 ABNA 0000 0000 01', (new IBAN(static::IBAN_TEST_NL))->format());
    }
}
