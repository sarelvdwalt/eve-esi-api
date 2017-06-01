<?php

namespace sarelvdwalt\eveESI;

class TokenEnvelopeTest extends \PHPUnit_Framework_TestCase
{
    /** @var $tokenEnvelope TokenEnvelope */
    protected $tokenEnvelope;

    protected function setUp()
    {
        $this->tokenEnvelope = new TokenEnvelope();
    }

    public function testSetGetAccessToken()
    {
        $this->assertEquals('1234', $this->tokenEnvelope->setAccessToken('1234')->getAccessToken());
    }

    public function testSetGetRefreshToken()
    {
        $this->assertEquals('1234', $this->tokenEnvelope->setRefreshToken('1234')->getRefreshToken());
    }

    public function testSetNonDateTimeObject()
    {
        $this->tokenEnvelope->setExpiresAt(new \DateTime());
    }
}
