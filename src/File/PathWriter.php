<?php

namespace Language\File;

class PathWriter implements WriterInterface
{
    /** @var PathBuilderInterface $pathBuilder */
    protected $pathBuilder;

    protected $flags = 0;

    protected $permissions = 0755;

    public function __construct(PathBuilderInterface $pathBuilder)
    {
        $this->pathBuilder = $pathBuilder;

        return $this;
    }

    public function write($content): bool
    {
        if ($this->flags & static::FLAG_GENERATE_DIRECTORIES) {
            $this->generateDirectories();
        }

        if (!is_dir($this->pathBuilder->getPath(true))) {
            throw new \Exception("Target directory does not exist or is not a directory");
        }

        if (!($this->flags & static::FLAG_OVERWRITE) && file_exists($this->pathBuilder->getPath())) {
            throw new \Exception("Target file already exists and writer is set to not overwrite");
        }

        $writeResult = file_put_contents($this->pathBuilder->getPath(), $content);

        if (!($this->flags & static::FLAG_CHECK_LENGTH) || $writeResult == false) {
            return (bool)$writeResult;
        } else {
            return strlen($content) == $writeResult;
        }
    }

    public function generateDirectories()
    {
        $directoryPath = $this->pathBuilder->getPath(true);

        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, $this->permissions, true);
        }
    }

    public function exists(bool $dirOnly = false): bool
    {
        return file_exists($this->pathBuilder->getPath($dirOnly));
    }

    public function setFlags(int $flags)
    {
        $this->flags = $flags;
    }

    public function setPermissions(int $permissions)
    {
        $this->permissions = $permissions;
    }
}
