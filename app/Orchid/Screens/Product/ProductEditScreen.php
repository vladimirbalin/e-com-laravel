<?php

namespace App\Orchid\Screens\Product;

use App\Orchid\Layouts\Product\ProductEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Src\Domain\Catalog\Models\Brand;
use Src\Domain\Product\Models\OptionValue;
use Src\Domain\Product\Models\Product;

class ProductEditScreen extends Screen
{
    /**
     * @var Product $product
     */
    public $product;

    public function query(Product $product): array
    {
        $product->load('optionValues.option');

        return [
            'product' => $product,
            'optionValues' => $product->optionValues
        ];
    }

    public function name(): ?string
    {
        return $this->product->exists ? 'Редактирование продукта ' . $this->product->id : 'Создание нового продукта';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Create post')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(! $this->product->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->product->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->product->exists),
        ];
    }

    public function layout(): iterable
    {
        return [
            ProductEditLayout::class
        ];
    }

    public function createOrUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'product.title' => 'required|string|max:255',
            'product.slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($this->product?->id)],
            'product.thumbnail' => 'nullable|string|max:255',
            'product.price' => 'nullable|numeric',
            'product.brand_id' => 'required|exists:brands,id',
            'product.optionValues' => ['array', Rule::exists('option_values', 'id')]
        ]);

        if ($this->product->exists) {
            $this->product->update(Arr::except($request->input('product'), ['optionValues']));
            $this->product->optionValues()->attach($request->input('product.optionValues'));

            Alert::info('You have successfully updated a post.');
        } else {
            $product = new Product();
            $product->title = $request->input('product.title');
            $product->slug = $request->input('product.slug');
            $product->thumbnail = $request->input('product.thumbnail');
            $product->price = $request->input('product.price');
            $product->brand_id = $request->input('product.brand_id');
            $this->product->optionValues()->attach($request->input('product.optionValues'));

            $product->save();

        }

        Alert::info('You have successfully created a post.');

        return redirect()->route('platform.products.index');
    }

    public function remove()
    {
        $this->product->delete();

        Alert::info('You have successfully deleted the post.');

        return redirect()->route('platform.products.index');
    }
}
