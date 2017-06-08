<?php

namespace sarelvdwalt\eveESI;

use GuzzleHttp\Client;
use sarelvdwalt\eveESI\swagger\Context;
use sarelvdwalt\eveESI\swagger\Parameter;
use Symfony\Component\VarDumper\VarDumper;

class API
{
    /** @var TokenEnvelope */
    protected $tokenEnvelope;

    /** @var APIOauth */
    protected $APIOauth;

    /** @var Client */
    protected $guzzleClient;

    protected $baseURL = 'https://esi.tech.ccp.is/latest';

    protected $operationIDMap = array();

    /** @var Context */
    protected $swaggerContext;

    public function __construct(Context $context, TokenEnvelope $tokenEnvelope = null, APIOauth $APIOauth = null)
    {
        $this->guzzleClient = new Client();
        $this->swaggerContext = $context;

        if (null !== $tokenEnvelope) {
            $this->tokenEnvelope = $tokenEnvelope;
        }

        if (null !== $APIOauth) {
            $this->APIOauth = $APIOauth;
        }
    }

    public function setTokenEnvelope(TokenEnvelope $tokenEnvelope)
    {
        $this->tokenEnvelope = $tokenEnvelope;

        return $this;
    }

    /**
     * Magic method that will look up whether the operation exists in the swagger context, and execute it.
     *
     * @param $name
     * @param $arguments
     * @return string
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        // Before each API call, check if the token should be refreshed and if so do the refresh call
        if ($this->tokenShouldGetRefresh()) {
            $this->tokenRefresh();
        }

        $operations = $this->swaggerContext->getOperations();

        $thisOperation = $operations[$this->underscore($name)];

        $requestOptions = array();
        $thisPath = $thisOperation->getPath();

        $requestOptions['query'] = array();

        $requestOptions['headers'] = array();
        if (isset($this->tokenEnvelope)) {
            $requestOptions['headers']['Authorization'] = 'Bearer ' . $this->tokenEnvelope->getAccessToken();
        }

        // Validate that all arguments sent through can be used:
        if (count($arguments) > 0) {
            foreach ($arguments[0] as $key => $value) {
                if (!array_key_exists($key, $thisOperation->getParameters())) {
                    throw new \Exception('You have to provide a parameter that is one of the following: ' . implode(',', array_keys($thisOperation->getParameters())));
                }

                /** @var Parameter $thisParameter */
                $thisParameter = $thisOperation->getParameters()[$key];
                switch ($thisParameter->getInType()) {
                    case 'query':
                        $requestOptions['query'][$key] = $value;
                        break;
                    case 'path':
                        $thisPath = str_replace('{'.$key.'}', $value, $thisPath);
                        break;
                    default:
                        throw new \Exception('Unsupported in-type. ' . $thisParameter->getInType() . ' given.');
                }
            }
        }

        $response = $this->guzzleClient->request($thisOperation->getMethod(), $this->baseURL . $thisPath, $requestOptions);

        return $response->getBody()->getContents();
    }

    protected function tokenShouldGetRefresh()
    {
        if (is_null($this->tokenEnvelope)) {
            return false;
        }

        $secondsToExpiry = ($this->tokenEnvelope->getExpiresAt()->getTimestamp() - (new \DateTime())->getTimestamp());
        VarDumper::dump($secondsToExpiry);

        if ($secondsToExpiry < 120) { // 2 minutes before it expires we want a new one
            return true;
        }

        return false;
    }

    protected function tokenRefresh()
    {
        $this->tokenEnvelope = $this->APIOauth->refreshAccessToken($this->tokenEnvelope);

        file_put_contents('play.token', serialize($this->tokenEnvelope));

        VarDumper::dump($this->tokenEnvelope);
    }

    /**
     * Perform reverse of camel-casing. Example: 'thisThing' => 'this_thing'
     *
     * @param $camelCasedWord
     * @return string
     */
    public function underscore($camelCasedWord)
    {
        $word = $camelCasedWord;
        return strtolower(preg_replace('/([a-z])([A-Z])/', "\${1}_\${2}", $word));
    }

}