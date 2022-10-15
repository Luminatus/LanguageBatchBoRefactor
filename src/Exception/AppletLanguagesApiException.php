<?php

namespace Language\Exception;

use Language\Api\Response\ApiErrorInterface;

class AppletLanguagesApiException extends ApiException
{
    public function __construct(string $applet, ApiErrorInterface $apiError)
    {
        parent::__construct($apiError);

        $this->message = "Getting languages for applet ($applet) was unsuccessful: " . $this->message;
    }
}
