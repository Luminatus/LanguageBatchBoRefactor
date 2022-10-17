<?php

namespace Language\Api\Response\Definition;

use Language\Api\Response\ApiErrorInterface;
use Language\File\FileType;

class EmptyContentErrorDefinition implements ApiErrorInterface
{
    public function getStatus(): string
    {
        return '';
    }

    public function isSuccess(): bool
    {
        return false;
    }

    public function getContent()
    {
        return "Wrong content!";
    }

    public function getErrorCode(): ?string
    {
        return null;
    }

    public function getErrorType(): ?string
    {
        return null;
    }

    public function getRawData()
    {
        return [
            'error_code' => $this->getErrorCode(),
            'error_type' => $this->getErrorType(),
            'data' => $this->getContent()
        ];
    }

    public function getType(): string
    {
        return FileType::TYPE_RAW;
    }
}
