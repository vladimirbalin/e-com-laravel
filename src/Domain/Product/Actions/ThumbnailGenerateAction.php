<?php
declare(strict_types=1);

namespace Src\Domain\Product\Actions;

use Illuminate\Contracts\Filesystem\Factory;
use Intervention\Image\ImageManager;
use Src\Domain\Product\DTOs\ThumbnailGenerateDto;

readonly class ThumbnailGenerateAction
{
    public function __construct(
        private Factory      $storage,
        private ImageManager $image
    ) {
    }

    public function handle(ThumbnailGenerateDto $dto): void
    {
        $storage = $this->storage->disk('images');

        $image = $this->image->read($storage->path($dto->getOriginalPath()));

        [$width, $height] = explode('x', $dto->getSize());

        $image->{$dto->getMethod()}((int) $width, (int) $height);

        $image->save($storage->path($dto->getNewPathWithFilename()));
    }
}
