<?php

namespace Language\Api\Response;

interface ApiResponseInterface
{
    public function isSuccess(): bool;
    public function getContent();
    public function getStatus(): ?string;
    public function getRawData();
}
