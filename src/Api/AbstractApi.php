<?php

namespace Language\Api;

use Language\Api\Processor\ApiResponseProcessor;
use Language\Api\Response\ApiResponseInterface;
use Language\ApiCall;
use ReflectionClass;

abstract class AbstractApi implements ApiInterface
{
    const PARAMETER_ACTION = 'action';
    const PARAMETER_SYSTEM = 'system';

    const API_NAME = '';

    protected static $modeList;

    public static function getApiName(): string
    {
        return static::API_NAME;
    }

    public static function getAvailableModes(): array
    {
        if (static::$modeList == null) {
            $modeList = [];
            $refl = new ReflectionClass(static::class);
            foreach ($refl->getConstants() as $key => $value) {
                if (substr($key, 0, 5) == 'MODE_') {
                    $modeList[] = $value;
                }
            }
            static::$modeList = $modeList;
        }

        return static::$modeList;
    }

    protected static function call(ApiConfiguration $config): ApiResponseInterface
    {
        $getParameters = $config->getGetParameters();

        $getParameters[static::PARAMETER_ACTION] = $config->getAction();
        $getParameters[static::PARAMETER_SYSTEM] = $config->getSystem();

        $result = ApiCall::call(
            $config->getApiName(),
            $config->getMode(),
            $getParameters,
            $config->getPostParameters()
        );

        return ApiResponseProcessor::process($result, $config);
    }

    protected static function createConfig()
    {
        return (new ApiConfiguration())
            ->setApiName(static::getApiName());
    }
}
