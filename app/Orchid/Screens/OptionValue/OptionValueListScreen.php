<?php

namespace App\Orchid\Screens\OptionValue;

use App\Orchid\Layouts\OptionValue\OptionValueListLayout;
use Orchid\Screen\Screen;
use Src\Domain\Product\Models\OptionValue;

class OptionValueListScreen extends Screen
{
    public function query(): iterable
    {
        return ['option-values' => OptionValue::latest()->paginate()];
    }

    public function name(): ?string
    {
        return 'OptionValueListScreen';
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [OptionValueListLayout::class];
    }
}
