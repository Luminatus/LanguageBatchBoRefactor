<?php

namespace Language\Api;

interface ApiInterface
{
    public static function getAvailableModes(): array;

    public static function getApiName(): string;
}
