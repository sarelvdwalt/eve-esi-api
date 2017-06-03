<?php

namespace sarelvdwalt\eveESI\response;

abstract class BaseResponse
{
    protected $description;

    protected $headers;

    protected $rawPayload;

    public function __construct($rawPayload)
    {
        $this->setDescription($rawPayload->description);
        $this->setHeaders($rawPayload->headers);
        $this->setRawPayload($rawPayload);
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     * @return BaseResponse
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRawPayload()
    {
        return $this->rawPayload;
    }

    /**
     * @param mixed $rawPayload
     * @return BaseResponse
     */
    public function setRawPayload($rawPayload)
    {
        $this->rawPayload = $rawPayload;
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
     * @return BaseResponse
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }


}