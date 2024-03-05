@if(flash()->get())
    <div class="{{flash()->get()->getClass()}}">
        {{ flash()->get()->getMessage() }}
    </div>
@endif
