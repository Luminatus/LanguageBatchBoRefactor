<?php

namespace Language\Exception;

use Language\Api\Response\ApiErrorInterface;

class LanguageFileApiException extends ApiException
{
    public function __construct(string $application, string $language, ApiErrorInterface $apiError)
    {
        parent::__construct($apiError);

        $this->message = "Error during getting language file: ($application/$language): " . $this->message;
    }
}
