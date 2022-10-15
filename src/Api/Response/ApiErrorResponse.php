<?php

namespace Language\Api\Response;

class ApiErrorResponse extends ApiResponse implements ApiErrorInterface
{
    public function getErrorType(): ?string
    {
        return $this->getRawData()['error_type'] ?: null;
    }

    public function getErrorCode(): ?string
    {
        return $this->getRawData()['error_code'] ?: null;
    }
}
