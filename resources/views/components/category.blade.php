<a href="{{route('catalog.index', array_merge(['category' => $category->slug], request()->query()))}}"
   class="p-3 sm:p-4 2xl:p-6 rounded-xl bg-card text-xxs sm:text-xs lg:text-sm text-white font-semibold
   @if(request()->route('category')?->id === $category->id) bg-pink @else hover:bg-pink @endif
   ">
    {{$category->title}}
</a>
