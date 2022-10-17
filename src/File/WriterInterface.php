<?php

namespace Language\File;

interface WriterInterface
{
    const FLAG_OVERWRITE = 1;
    const FLAG_GENERATE_DIRECTORIES = 2;
    const FLAG_CHECK_LENGTH = 3;

    public function write($content);

    public function generateDirectories();

    public function exists(bool $dirOnly = false): bool;

    public function setFlags(int $flags);

    public function setPermissions(int $permissions);
}
