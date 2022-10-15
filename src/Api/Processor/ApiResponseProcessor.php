<?php

namespace Language\Api\Processor;

use Language\Api\Response\ApiErrorResponse;
use Language\Api\Response\ApiResponse;
use Language\Api\Response\ApiResponseInterface;
use Language\Api\Response\Definition\ApiErrorDefinitionInterface;
use Language\Api\Response\Definition\EmptyResponseErrorDefinition;

class ApiResponseProcessor
{
    public static function process($rawData): ApiResponseInterface
    {
        if (!$rawData) {
            return new EmptyResponseErrorDefinition();
        }

        $errorCode = $rawData['error_code'] ?: null;
        $errorType = $rawData['error_type'] ?: null;

        if (!$errorCode && !$errorType) {
            return new ApiResponse($rawData);
        } else {
            return new ApiErrorResponse($rawData);
        }
    }
}
