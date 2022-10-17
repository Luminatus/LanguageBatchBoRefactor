<?php

namespace Language\File;

interface PathBuilderInterface
{
    public function getPath(bool $excludeFileName = false): string;

    public function dir(string $dir): self;

    public function file(string $fileName, string $extension = ''): self;
}
