<?php

namespace Language\Api;

use Language\Api\Response\ApiResponse;
use Language\File\FileType;

final class SystemApi extends AbstractApi
{
    const API_NAME = 'system_api';

    const MODE_LANGUAGE = 'language_api';

    const SYSTEM_LANGUAGE = 'LanguageFiles';

    const PARAMETER_LANGUAGE = 'language';
    const PARAMETER_APPLET = 'applet';

    private const ACTION_GET_LANGUAGE_FILE = 'getLanguageFile';
    private const ACTION_GET_APPLET_LANGUAGES = 'getAppletLanguages';
    private const ACTION_GET_APPLET_LANGUAGE_FILE = 'getAppletLanguageFile';

    public static function getLanguageFile(string $language, $getParameters = [], $postParameters = [])
    {
        $postParameters[static::PARAMETER_LANGUAGE] = $language;

        $config = static::createConfig();
        $config
            ->setAction(static::ACTION_GET_LANGUAGE_FILE)
            ->setMode(static::MODE_LANGUAGE)
            ->setSystem(static::SYSTEM_LANGUAGE)
            ->setGetParameters($getParameters)
            ->setPostParameters($postParameters)
            ->setResponseType(FileType::TYPE_PHP);

        return static::call($config);
    }

    public static function getAppletLanguages(string $applet, array $getParameters = [], $postParameters = [])
    {
        $postParameters[static::PARAMETER_APPLET] = $applet;

        $config = static::createConfig();
        $config
            ->setAction(static::ACTION_GET_APPLET_LANGUAGES)
            ->setMode(static::MODE_LANGUAGE)
            ->setSystem(static::SYSTEM_LANGUAGE)
            ->setGetParameters($getParameters)
            ->setPostParameters($postParameters);

        return static::call($config);
    }

    public static function getAppletLanguageFile(string $applet, string $language, $getParameters = [], $postParameters = [])
    {
        $postParameters[static::PARAMETER_APPLET] = $applet;
        $postParameters[static::PARAMETER_LANGUAGE] = $language;

        $config = static::createConfig();
        $config
            ->setAction(static::ACTION_GET_APPLET_LANGUAGE_FILE)
            ->setMode(static::MODE_LANGUAGE)
            ->setSystem(static::SYSTEM_LANGUAGE)
            ->setGetParameters($getParameters)
            ->setPostParameters($postParameters)
            ->setResponseType(FileType::TYPE_XML);

        return static::call($config);
    }
}
