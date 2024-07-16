<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Src\Domain\Product\Actions\ThumbnailGenerateAction;
use Src\Domain\Product\DTOs\ThumbnailGenerateDto;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ThumbnailController extends Controller
{
    public function __construct(
        private readonly ThumbnailGenerateAction $thumbnailGenerate
    ) {
    }

    public function __invoke(
        string  $dir,
        string  $method,
        string  $size,
        string  $folder,
        ?string $file = null,
    ): BinaryFileResponse {
        $this->validateSize($size);

        $storage = Storage::disk('images');

        // if $file is null, then folder variable contains filename
        $originalPath = is_null($file) ? "$dir/$folder" : "$dir/$folder/$file";
        $newPath = is_null($file) ? "$dir/$method/$size" : "$dir/$method/$size/$folder";
        $newPathWithFilename = is_null($file) ? "$dir/$method/$size/$folder" : "$dir/$method/$size/$folder/$file";

        if (! $storage->exists($newPath)) {
            $storage->makeDirectory($newPath);
        }

        if (! $storage->exists($newPathWithFilename)) {
            $dto = new ThumbnailGenerateDto($size, $method, $originalPath, $newPathWithFilename);
            $this->thumbnailGenerate->handle($dto);
        }

        return response()->file($storage->path($newPathWithFilename));
    }

    private function validateSize(string $size): void
    {
        abort_if(
            ! in_array($size, config('thumbnail.allowed_sizes', [])),
            403,
            'Size not allowed'
        );
    }
}
