<?php

namespace Language\Exception;

use Language\Api\Response\ApiErrorInterface;

class AppletLanguageFileApiException extends ApiException
{
    public function __construct(string $applet, string $language, ApiErrorInterface $apiError)
    {
        parent::__construct($apiError);

        $this->message = "Getting language xml for applet: ($applet) on language: ($language) was unsuccessful: " . $this->message;
    }
}
