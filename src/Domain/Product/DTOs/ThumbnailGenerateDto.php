<?php
declare(strict_types=1);

namespace Src\Domain\Product\DTOs;

class ThumbnailGenerateDto
{
    public function __construct(
        private readonly string $size,
        private readonly string $method,
        private readonly string $originalPath,
        private readonly string $newPathWithFilename
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getOriginalPath(): string
    {
        return $this->originalPath;
    }

    public function getNewPathWithFilename(): string
    {
        return $this->newPathWithFilename;
    }

    public function getSize(): string
    {
        return $this->size;
    }
}
