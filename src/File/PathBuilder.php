<?php

namespace Language\File;

use Language\Config;

class PathBuilder implements PathBuilderInterface
{
    const SANITIZE_FILENAME = 1;
    const SANITIZE_EXTENSION = 2;

    /** @var string $basePath */
    protected $basePath;

    /** @var array|string[] $dirs */
    protected $dirs = [];

    /** @var string fileName */
    protected $fileName;

    /** @var string $extension */
    protected $extension;

    private function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    static public function root()
    {
        return new static(Config::get('system.paths.root'));
    }

    static public function cache()
    {
        return (new static(Config::get('system.paths.root')))->dir('cache');
    }

    public function dir(string $dir): self
    {
        $dir = $this->sanitizeInput($dir);
        if ($this->validPathElement($dir)) {
            $this->dirs[] = $dir;
        } else {
            throw new \Exception("Invalid directory name provided");
        }

        return $this;
    }

    public function file(string $fileName, string $extension = ''): self
    {
        $noExtension = empty($extension);

        $fileName = $this->sanitizeInput($fileName, static::SANITIZE_FILENAME);
        $extension = $this->sanitizeInput($extension, static::SANITIZE_EXTENSION);

        if ($this->validPathElement($fileName) && ($noExtension || $this->validPathElement($extension))) {
            $this->fileName = $fileName;
            $this->extension = $extension;
        } else {
            throw new \Exception("Invalid filename or extension provided");
        }

        return $this;
    }

    public function getPath(bool $excludeFile = false): string
    {
        $path = $this->basePath;

        foreach ($this->dirs as $dir) {
            $path .= DIRECTORY_SEPARATOR . $dir;
        }

        if (!$excludeFile && !empty($this->fileName)) {
            $path .= DIRECTORY_SEPARATOR . $this->fileName;

            if (!empty($this->extension)) {
                $path .= '.' . $this->extension;
            }
        }

        return $path;
    }

    private function sanitizeInput(string $input, int $flags = 0): string
    {
        $input = trim($input, "\\/ \t");
        if ($flags | static::SANITIZE_EXTENSION) {
            $input = trim($input, '.');
        }
        if ($flags | static::SANITIZE_FILENAME) {
            $input = rtrim($input, '.');
        }

        return $input;
    }

    private function validPathElement(string $input): bool
    {
        return
            !empty($input)
            && !in_array($input, ['.', '..'])
            && pathinfo($input, PATHINFO_BASENAME) == $input;
    }
}
