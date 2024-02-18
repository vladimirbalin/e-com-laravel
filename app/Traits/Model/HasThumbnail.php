<?php
declare(strict_types=1);

namespace App\Traits\Model;

use Illuminate\Support\Facades\File;

trait HasThumbnail
{
    abstract protected function thumbnailDir(): string;

    abstract protected function hasSubfolder(): bool;

    public function makeThumbnail(string $size, string $method = 'resize'): string
    {
        $filename = File::basename($this->{$this->thumbnailColumn()});

        return route('thumbnail', [
            'size' => $size,
            'dir' => $this->thumbnailDir(),
            'method' => $method,
            'folder' => $this->hasSubfolder() ? today()->format('Y-m-d') : $filename,
            'file' => $this->hasSubfolder() ? $filename : null
        ]);
    }

    protected function thumbnailColumn(): string
    {
        return 'thumbnail';
    }
}
