<?php /** @var \App\Filters\BrandsFilter $filter */ ?>
<div>
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">{{$filter->title()}}</h5>
    @foreach($filter->values() as $id => $label)
        <div class="form-checkbox">
            <input type="checkbox"
                   id="{{$id}}"
                   name="{{$filter->name($id)}}"
                   value="{{$id}}"
                    @checked($filter->requestValue($id))
            >
            <label for="{{$id}}"
                   class="form-checkbox-label">{{$label}}
{{--                ({{$brand->products_count}})--}}
            </label>
        </div>
    @endforeach
</div>
