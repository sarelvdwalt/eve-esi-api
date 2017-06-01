<?php

namespace sarelvdwalt\eveESI;

class TokenEnvelopeTest extends \PHPUnit_Framework_TestCase
{
    protected $tokenEnvelope;

    protected function setUp()
    {
        $this->tokenEnvelope = new TokenEnvelope();
    }

    public function testSetGetAccessToken()
    {
        $obj = new TokenEnvelope();

        $this->assertNotNull($obj);
    }
}
