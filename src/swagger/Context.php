<?php

namespace sarelvdwalt\eveESI\swagger;

use Symfony\Component\VarDumper\VarDumper;

class Context
{
//    protected $swaggerJSON;

    protected $basePath;
    protected $host;
    protected $info;
    protected $swagger;
    protected $produces;
    protected $schemes;
    protected $securityDefinitions;

    /** @var Operation[] */
    protected $operations;

    public function __construct($swaggerURI)
    {
        $swaggerJSON = \GuzzleHttp\json_decode(file_get_contents($swaggerURI), true);

        $this->basePath = $swaggerJSON['basePath'];
        $this->host = $swaggerJSON['host'];
        $this->info = $swaggerJSON['info'];
        $this->swagger = $swaggerJSON['swagger'];
        $this->produces = $swaggerJSON['produces'];
        $this->schemes = $swaggerJSON['schemes'];
        $this->securityDefinitions = $swaggerJSON['securityDefinitions'];

        foreach ($swaggerJSON['paths'] as $pathkey => $path) {
            foreach ($path as $method => $operation) {
                $tmpOperation = new Operation($operation['operationId']);
                $tmpOperation
                    ->setPath($pathkey)
                    ->setMethod($method)
                    ->setSummary($operation['summary'])
                    ->setDescription($operation['description'])
                    ->setTags($operation['tags']);

                // Iterate and create parameter objects:
                $tmpParameters = array();
                foreach ($operation['parameters'] as $parameter) {
                    $tmpParameter = new Parameter();
                    $tmpParameter->setDescription($parameter['description']);
                    $tmpParameter->setInType($parameter['in']);
                    $tmpParameter->setName($parameter['name']);
                    $tmpParameter->setDataType(array_key_exists('type', $parameter) ? $parameter['type'] : null);
                    $tmpParameter->setRequired(array_key_exists('required', $parameter) ? $parameter['required'] : false);

                    $tmpParameters[$tmpParameter->getName()] = $tmpParameter;
                }
                $tmpOperation->setParameters($tmpParameters);

                // Get security context:
                if (array_key_exists('security', $operation)) {
                    $tmpOperation->setSecurity($operation['security']);
                }

                $this->operations[$operation['operationId']] = $tmpOperation;
            }
        }
    }

    /**
     * @return Operation[]
     */
    public function getOperations()
    {
        return $this->operations;
    }
}