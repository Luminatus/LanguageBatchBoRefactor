<?php

namespace Language\Api\Response;

class ApiResponse implements ApiResponseInterface
{
    const STATUS_OK = 'OK';

    protected $rawData;

    public function __construct(array $rawData)
    {
        $this->rawData = $rawData;
    }

    public function getRawData()
    {
        return $this->rawData;
    }

    public function isSuccess(): bool
    {
        return $this->getStatus() == static::STATUS_OK;
    }

    public function getStatus(): string
    {
        return $this->rawData['status'] ?: null;
    }

    public function getContent()
    {
        return $this->rawData['data'] ?: null;
    }
}
