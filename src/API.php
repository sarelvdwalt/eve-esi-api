<?php

namespace sarelvdwalt\eveESI;

use GuzzleHttp\Client;
use sarelvdwalt\eveESI\response\getStatusOK;
use Symfony\Component\VarDumper\VarDumper;

class API
{
    /** @var TokenEnvelope */
    protected $tokenEnvelope;

    /** @var Client */
    protected $guzzleClient;

    protected $baseURL = 'https://esi.tech.ccp.is/latest';

    public function __construct()
    {
        $this->guzzleClient = new Client();
    }

    public function setTokenEnvelope(TokenEnvelope $tokenEnvelope)
    {
        $this->tokenEnvelope = $tokenEnvelope;

        return $this;
    }

    public function getStatus()
    {
        $response = $this->guzzleClient->get($this->baseURL.'/status/');

        VarDumper::dump(new getStatusOK(\GuzzleHttp\json_decode($response->getBody()->getContents())));
    }
}