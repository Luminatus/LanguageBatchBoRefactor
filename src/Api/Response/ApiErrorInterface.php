<?php

namespace Language\Api\Response;

interface ApiErrorInterface extends ApiResponseInterface
{
    public function getErrorType(): ?string;

    public function getErrorCode(): ?string;
}
