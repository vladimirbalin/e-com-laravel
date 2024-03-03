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
        $filename = File::basename($this->getThumbnailValue());
        $folder = $this->hasSubfolder() ?
            $this->extractFolderFromThumbnail()
            : $filename;

        return route('thumbnail', [
            'size' => $size,
            'dir' => $this->thumbnailDir(),
            'method' => $method,
            'folder' => $folder,
            'file' => $this->hasSubfolder() ? $filename : null
        ]);
    }

    protected function thumbnailColumn(): string
    {
        return 'thumbnail';
    }

    private function getThumbnailValue()
    {
        return $this->{$this->thumbnailColumn()};
    }

    private function extractFolderFromThumbnail(): string
    {
        return str($this->getThumbnailValue())
            ->explode('/')
            ->slice(-2, 1)
            ->first();
    }
}
