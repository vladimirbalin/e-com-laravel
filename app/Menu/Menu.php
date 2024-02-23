<?php
declare(strict_types=1);

namespace App\Menu;

use Illuminate\Support\Collection;

class Menu
{
    protected array $items = [];

    public function __construct(MenuItem ...$items)
    {
        $this->items = $items;
    }

    public function all(): Collection
    {
        return collect($this->items);
    }
}
