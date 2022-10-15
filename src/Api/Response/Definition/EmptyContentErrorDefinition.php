<?php

namespace Language\Api\Response\Definition;

use Language\Api\Response\ApiErrorInterface;

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
}
