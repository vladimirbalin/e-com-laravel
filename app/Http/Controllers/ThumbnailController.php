<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ThumbnailController extends Controller
{
    public function __construct(private readonly ImageManager $image)
    {
    }

    public function __invoke(
        string  $dir,
        string  $method,
        string  $size,
        string  $file,
        Request $request
    ): BinaryFileResponse {
        $this->validateSize($size);

        $storage = Storage::disk('images');

        $originalPath = "$dir/$file";
        $newPath = "$dir/$method/$size";
        $fullPathWithFilename = "$newPath/$file";

        if (! $storage->exists($newPath)) {
            $storage->makeDirectory($newPath);
        }

        if (! $storage->exists($fullPathWithFilename)) {
            $image = $this->image->read($storage->path($originalPath));

            [$width, $height] = explode('x', $size);

            $image->{$method}((int) $width, (int) $height);

            $image->save($storage->path($fullPathWithFilename));
        }

        return response()->file($storage->path($fullPathWithFilename));
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
