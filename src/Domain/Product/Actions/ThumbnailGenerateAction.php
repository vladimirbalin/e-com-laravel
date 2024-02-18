<?php
declare(strict_types=1);

namespace Src\Domain\Product\Actions;

use Illuminate\Contracts\Filesystem\Filesystem;
use Intervention\Image\ImageManager;
use Src\Domain\Product\DTOs\ThumbnailGenerateDto;

readonly class ThumbnailGenerateAction
{
    public function __construct(
        private Filesystem   $storage,
        private ImageManager $image
    ) {
    }

    public function handle(
       ThumbnailGenerateDto $dto
    ): void {
        $image = $this->image->read($this->storage->path($dto->getOriginalPath()));

        [$width, $height] = explode('x', $dto->getSize());

        $image->{$dto->getMethod()}((int) $width, (int) $height);

        $image->save($this->storage->path($dto->getNewPathWithFilename()));
    }
}
