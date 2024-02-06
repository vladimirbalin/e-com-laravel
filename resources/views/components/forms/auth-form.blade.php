<h1 class="mb-5 text-lg font-semibold">{{ $title }}</h1>
<form class="space-y-3" {{ $attributes->except('title') }}>
    @csrf
    {{ $slot }}
</form>
{{ $links }}
{{ $politics }}
