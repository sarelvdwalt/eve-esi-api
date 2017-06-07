<?php

namespace sarelvdwalt\eveESI;

use GuzzleHttp\Client;
use sarelvdwalt\eveESI\swagger\Context;
use sarelvdwalt\eveESI\swagger\Parameter;
use sarelvdwalt\eveESI\swagger\ParameterInType;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class API
 * @package sarelvdwalt\eveESI
 *
 * @method getStatus(string $datasource = "tranquility", string $user_agent = null, string $xUserAgent = null) Gets the current server status
 */
class API
{
    /** @var TokenEnvelope */
    protected $tokenEnvelope;

    /** @var Client */
    protected $guzzleClient;

    protected $baseURL = 'https://esi.tech.ccp.is/latest';

    protected $operationIDMap = array();

    /** @var Context */
    protected $swaggerContext;

    public function __construct(Context $context)
    {
        $this->guzzleClient = new Client();
        $this->swaggerContext = $context;
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
        $operations = $this->swaggerContext->getOperations();

        $thisOperation = $operations[$this->underscore($name)];

        $requestOptions = array();

        // Validate that all arguments sent through can be used:
        foreach ($arguments[0] as $key => $value) {
            if (!array_key_exists($key, $thisOperation->getParameters())) {
                throw new \Exception('You have to provide a parameter that is one of the following: '.implode(',', array_keys($thisOperation->getParameters())));
            }

            /** @var Parameter $thisParameter */
            $thisParameter = $thisOperation->getParameters()[$key];
            switch ($thisParameter->getInType()) {
                case 'query': {
                    $requestOptions['query'] = [
                        $key => $value
                    ];
                }; break;
                default: throw new \Exception('Unsupported in-type. '.$thisParameter->getInType().' given.');
            }
        }

        $response = $this->guzzleClient->request($thisOperation->getMethod(), $this->baseURL . $thisOperation->getPath(), $requestOptions);

        return $response->getBody()->getContents();
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