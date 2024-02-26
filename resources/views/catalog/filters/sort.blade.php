<div x-data="{sort: '{{ catalog_filters_url($category ?? null, request('filters', [])) }}'}">
    <select
        x-model="sort"
        x-on:change="window.location = sort"
        name="{{ $filter->name() }}"
        class="form-select w-full h-12 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xxs sm:text-xs shadow-transparent outline-0 transition">
        @foreach($filter->values() as $value => $label)
            <option value="{{catalog_filters_url($category ?? null, ['sort' => $value])}}"
                    @selected($value === request('filters.sort')) class="text-dark">
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>
