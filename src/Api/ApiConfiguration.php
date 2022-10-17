<?php

namespace Language\Api;

class ApiConfiguration
{
    protected $apiName;
    protected $system;
    protected $mode;
    protected $action;

    protected $responseType;

    protected $getParameters;
    protected $postParameters;

    public function getApiName(): string
    {
        return $this->apiName;
    }

    public function getSystem(): string
    {
        return $this->system;
    }

    public function getMode(): string
    {
        return $this->mode;
    }
    public function getAction(): string
    {
        return $this->action;
    }
    public function getGetParameters(): array
    {
        return $this->getParameters;
    }
    public function getPostParameters(): array
    {
        return $this->postParameters;
    }
    public function getResponseType(): ?string
    {
        return $this->responseType;
    }


    public function setApiName(string $apiName)
    {
        $this->apiName = $apiName;
        return $this;
    }

    public function setSystem(string $system)
    {
        $this->system = $system;
        return $this;
    }
    public function setMode(string $mode)
    {
        $this->mode = $mode;
        return $this;
    }
    public function setAction(string $action)
    {
        $this->action = $action;
        return $this;
    }
    public function setGetParameters(array $getParameters)
    {
        $this->getParameters = $getParameters;
        return $this;
    }
    public function setPostParameters(array $postParameters)
    {
        $this->postParameters = $postParameters;
        return $this;
    }
    public function setResponseType(string $responseType)
    {
        $this->responseType = $responseType;
        return $this;
    }
}
