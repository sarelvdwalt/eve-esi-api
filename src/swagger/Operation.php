<?php

namespace sarelvdwalt\eveESI\swagger;

class Operation
{
    protected $operationId;
    protected $description;
    protected $parameters;
    protected $responses;
    protected $summary;
    protected $tags;
    protected $security;

    /**
     * @return mixed
     */
    public function getSecurity()
    {
        return $this->security;
    }

    /**
     * @param mixed $security
     * @return Operation
     */
    public function setSecurity($security)
    {
        $this->security = $security;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Operation
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     * @return Operation
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * @param mixed $responses
     * @return Operation
     */
    public function setResponses($responses)
    {
        $this->responses = $responses;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param mixed $summary
     * @return Operation
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     * @return Operation
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    protected $path;
    protected $method;

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     * @return Operation
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return Operation
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function __construct($id)
    {
        $this->setOperationId($id);
    }

    /**
     * @return mixed
     */
    public function getOperationId()
    {
        return $this->operationId;
    }

    /**
     * @param mixed $operationId
     * @return Operation
     */
    public function setOperationId($operationId)
    {
        $this->operationId = $operationId;
        return $this;
    }
}