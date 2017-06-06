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

    /**
     * @return Operation[]
     */
    public function getOperations()
    {
        return $this->operations;
    }

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
                    ->setTags($operation['tags'])
                    ->setParameters($operation['parameters'])
                ;

                if (array_key_exists('security', $operation)) {
                    $tmpOperation->setSecurity($operation['security']);
                }

                $this->operations[$operation['operationId']] = $tmpOperation;
            }
        }
    }
}