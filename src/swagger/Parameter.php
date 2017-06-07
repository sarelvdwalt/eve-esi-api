<?php

namespace sarelvdwalt\eveESI\swagger;

class Parameter
{
    /** @var ParameterInType */
    protected $inType;

    /** @var string */
    protected $description;

    /** @var string */
    protected $name;

    /** @var bool */
    protected $required;

    protected $dataType;

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param bool $required
     * @return Parameter
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * @param mixed $dataType
     * @return Parameter
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Parameter
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Parameter
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return ParameterInType
     */
    public function getInType()
    {
        return $this->inType;
    }

    /**
     * @param ParameterInType $inType
     * @return Parameter
     */
    public function setInType($inType)
    {
        $this->inType = $inType;
        return $this;
    }
}