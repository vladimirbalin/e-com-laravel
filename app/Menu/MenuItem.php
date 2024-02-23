<?php
declare(strict_types=1);

namespace App\Menu;

class MenuItem
{
    public function __construct(
        private string $title,
        private string $link,
    ) {
    }

    public function isActive(): bool
    {
        $path = parse_url($this->getLink(), PHP_URL_PATH) ?? '/';

        if ($path === '/') {
            return request()->path() === $path;
        }

        return request()->fullUrlIs($this->getLink() . '*');
    }

    public function getLink(): string
    {
        return $this->link;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
}
