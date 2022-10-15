<?php

namespace Language\Exception;

use Language\Api\Response\ApiErrorInterface;

class ApiException extends \Exception
{
    /** @var ApiErrorInterface $apiError */
    protected $apiError;

    public function __construct(ApiErrorInterface $result)
    {
        $this->apiError = $result;
        $this->initException();
    }

    public function getApiError()
    {
        return $this->apiError;
    }

    protected function initException()
    {
        $this->message =
            $this->getErrorTypeString()
            . $this->getErrorCodeString()
            . $this->getErrorContentString();

        if (empty($this->message)) {
            $this->message = sprintf("An error occured during the API call.");
        }
    }

    protected function getErrorTypeString()
    {
        $typeString = '';
        if ($this->apiError->getErrorType() != null) {
            $typeString = 'Type(' . $this->apiError->getErrorType() . ') ';
        }

        return $typeString;
    }

    protected function getErrorCodeString()
    {
        $codeString = '';
        if ($this->apiError->getErrorCode() != null) {
            $codeString = 'Code(' . $this->apiError->getErrorCode() . ') ';
        }

        return $codeString;
    }

    protected function getErrorContentString()
    {
        $contentString = '';
        if (is_scalar($this->apiError->getContent())) {
            $contentString = $this->apiError->getContent();
        }

        return $contentString;
    }
}
