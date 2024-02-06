<form class="space-y-3" action="{{ route('logout') }}" method="post" {{ $attributes->merge() }}>
    @csrf
    @method('DELETE')

    <button
        type="submit"
        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
        {{ $slot }}
    </button>

</form>
