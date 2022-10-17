<?php

namespace Language\Api\Response;

use Language\File\FileType;

class ApiResponse implements ApiResponseInterface
{
    const STATUS_OK = 'OK';

    protected $rawData;

    protected $type;

    public function __construct(array $rawData, string $type = FileType::TYPE_RAW)
    {
        $this->rawData = $rawData;
        $this->type = $type;
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

    public function getType(): string
    {
        return $this->type;
    }
}
