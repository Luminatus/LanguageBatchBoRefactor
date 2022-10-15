<?php

namespace Language\Api\Processor;

use Language\Api\Response\ApiErrorResponse;
use Language\Api\Response\ApiResponse;
use Language\Api\Response\ApiResponseInterface;
use Language\Api\Response\Definition\NoResponseErrorDefinition;

class ApiResponseProcessor
{
    public static function process($rawData): ApiResponseInterface
    {
        if (!$rawData) {
            return new NoResponseErrorDefinition();
        }

        $status = $rawData['status'] ?: null;

        if ($status == ApiResponse::STATUS_OK) {
            return new ApiResponse($rawData);
        } else {
            return new ApiErrorResponse($rawData);
        }
    }
}
