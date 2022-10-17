<?php

namespace Language\Api\Processor;

use Language\Api\ApiConfiguration;
use Language\Api\Response\ApiErrorResponse;
use Language\Api\Response\ApiResponse;
use Language\Api\Response\ApiResponseInterface;
use Language\Api\Response\Definition\NoResponseErrorDefinition;
use Language\File\FileType;

class ApiResponseProcessor
{
    public static function process($rawData, ApiConfiguration $config): ApiResponseInterface
    {
        $type = $config->getResponseType() ?? FileType::TYPE_RAW;

        if (!$rawData) {
            return new NoResponseErrorDefinition();
        }

        $status = $rawData['status'] ?: null;

        if ($status == ApiResponse::STATUS_OK) {
            return new ApiResponse($rawData, $type);
        } else {
            return new ApiErrorResponse($rawData, FileType::TYPE_RAW);
        }
    }
}
