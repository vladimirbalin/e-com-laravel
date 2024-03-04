@extends('layouts.app')
@section('content')
    <main class="py-16 lg:py-20">
        <div class="container">

            <!-- Breadcrumbs -->
            <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
                <li><a href="{{ route('home') }}" class="text-body hover:text-pink text-xs">Главная</a></li>
                <li><span class="text-body text-xs">Корзина покупок</span></li>
            </ul>

            <section>
                <!-- Section heading -->
                <h1 class="mb-8 text-lg lg:text-[42px] font-black">Корзина покупок</h1>
                @if(!$cart || !$cart->cartItems->count())
                    <!-- Message -->
                    <div class="py-3 px-6 rounded-lg bg-pink text-white">Корзина пуста</div>
                @else
                    <!-- Adaptive table -->
                    <div class="overflow-auto">
                        <table class="min-w-full border-spacing-y-4 text-white text-sm text-left"
                               style="border-collapse: separate">
                            <thead class="text-xs uppercase">
                            <th scope="col" class="py-3 px-6">Товар</th>
                            <th scope="col" class="py-3 px-6">Цена</th>
                            <th scope="col" class="py-3 px-6">Количество</th>
                            <th scope="col" class="py-3 px-6">Сумма</th>
                            <th scope="col" class="py-3 px-6"></th>
                            </thead>
                            <tbody>
                            @foreach($cart->cartItems ?? [] as $cartItem)
                                    <?php /** @var \Src\Domain\Cart\Models\CartItem $cartItem */ ?>
                                <tr>
                                    <td scope="row" class="py-4 px-4 md:px-6 rounded-l-2xl bg-card">
                                        <div class="flex flex-col lg:flex-row min-w-[200px] gap-2 lg:gap-6">
                                            <div
                                                class="shrink-0 overflow-hidden w-[64px] lg:w-[84px] h-[64px] lg:h-[84px] rounded-2xl">
                                                <img src="{{ $cartItem->product->makeThumbnail('150x150') }}"
                                                     class="object-cover w-full h-full"
                                                     alt="SteelSeries Aerox 3 Snow">
                                            </div>
                                            <div class="py-3">
                                                <h4 class="text-xs sm:text-sm xl:text-md font-bold">
                                                    <a href="{{ route('products.show', $cartItem->product->slug) }}"
                                                       class="inline-block text-white hover:text-pink">{{ $cartItem->product->title }}</a>
                                                </h4>
                                                <ul class="space-y-1 mt-2 text-xs">
                                                    @foreach($cartItem->optionValues as $optionValue)
                                                        <li class="text-body">{{ $optionValue->option->title }}
                                                            : {{ $optionValue->title }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 md:px-6 bg-card">
                                        <div
                                            class="font-medium whitespace-nowrap">{{ $cartItem->price->getFormattedValueWithSymbol() }}</div>
                                    </td>
                                    <td class="py-4 px-4 md:px-6 bg-card">


                                        <div class="flex items-stretch h-[56px] gap-2">
                                            <form action="{{ route('cart.quantity', $cartItem) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="quantity"
                                                       value="{{ $cartItem->quantity - 1 }}">
                                                <button type="submit"
                                                        class="w-12 h-full rounded-lg border border-body/10 hover:bg-card/20 active:bg-card/50 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs text-center font-bold shadow-transparent outline-0 transition">
                                                    -
                                                </button>
                                            </form>
                                            <form action="{{ route('cart.quantity', $cartItem) }}" method="post">
                                                @csrf
                                                <input name="quantity"
                                                       type="number"
                                                       class="h-full px-2 lg:px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs text-center font-bold shadow-transparent outline-0 transition"
                                                       min="1" max="999" value="{{ $cartItem->quantity }}"
                                                       placeholder="К-во">
                                            </form>
                                            <form action="{{ route('cart.quantity', $cartItem) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="quantity"
                                                       value="{{ $cartItem->quantity + 1 }}">
                                                <button name="quantity"
                                                        type="submit"
                                                        class="w-12 h-full rounded-lg border border-body/10 hover:bg-card/20 active:bg-card/50 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs text-center font-bold shadow-transparent outline-0 transition">
                                                    +
                                                </button>
                                            </form>
                                        </div>

                                    </td>
                                    <td class="py-4 px-4 md:px-6 bg-card">
                                        <div
                                            class="font-medium whitespace-nowrap">{{ $cartItem->price->multiplyBy($cartItem->quantity)->getFormattedValueWithSymbol() }}</div>
                                    </td>
                                    <td class="py-4 px-4 md:px-6 rounded-r-2xl bg-card">
                                        <form action="{{ route('cart.delete', $cartItem) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" href="{{ route('cart.delete', $cartItem)  }}"
                                                    class="w-12 !h-12 !px-0 btn btn-pink"
                                                    title="Удалить из корзины">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                     fill="currentColor"
                                                     viewBox="0 0 52 52">
                                                    <path
                                                        d="M49.327 7.857H2.673a2.592 2.592 0 0 0 0 5.184h5.184v31.102a7.778 7.778 0 0 0 7.776 7.776h20.735a7.778 7.778 0 0 0 7.775-7.776V13.041h5.184a2.592 2.592 0 0 0 0-5.184Zm-25.919 28.51a2.592 2.592 0 0 1-5.184 0V23.409a2.592 2.592 0 1 1 5.184 0v12.96Zm10.368 0a2.592 2.592 0 0 1-5.184 0V23.409a2.592 2.592 0 1 1 5.184 0v12.96ZM20.817 5.265h10.367a2.592 2.592 0 0 0 0-5.184H20.817a2.592 2.592 0 1 0 0 5.184Z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mt-8">
                        <div class="text-[32px] font-black">Итого: {{ $totalPrice->getFormattedValueWithSymbol() }}</div>
                        <div class="pb-3 lg:pb-0">
                            <form action="{{ route('cart.truncate') }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-body hover:text-pink font-medium">Очистить корзину
                                </button>
                            </form>
                        </div>
                        <div class="flex flex-col sm:flex-row lg:justify-end gap-4">
                            <a href="{{ route('catalog.index') }}" class="btn btn-pink">За покупками</a>
                            <a href="{{ route('checkout.index') }}" class="btn btn-purple">Оформить заказ</a>
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </main>
@endsection
