<nav class="2xl:flex gap-8">
    @foreach($menu->all() as $item)
        <x-menu-item :item="$item"></x-menu-item>
    @endforeach
{{--    <a href="{{route('home')}}" class="text-white hover:text-pink font-bold">Главная</a>--}}
{{--    <a href="{{route('catalog.index')}}" class="text-white hover:text-pink font-bold">Каталог товаров</a>--}}
{{--    <a href="#" class="text-white hover:text-pink font-bold">Корзина</a>--}}
</nav>
