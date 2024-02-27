<?php

namespace App\Orchid\Screens\Option;

use App\Orchid\Layouts\Option\OptionListLayout;
use Orchid\Screen\Screen;
use Src\Domain\Product\Models\Option;

class OptionListScreen extends Screen
{
    public function query(): iterable
    {
        return ['options' => Option::latest()->paginate()];
    }

    public function name(): ?string
    {
        return 'OptionListScreen';
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [OptionListLayout::class];
    }
}
