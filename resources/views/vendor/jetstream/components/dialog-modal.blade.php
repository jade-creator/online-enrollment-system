@props(['id' => null, 'maxWidth' => null, 'closeBtn' => false])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <h1 class="px-6 py-4 text-lg font-bold w-full border-b border-gray-100 flex items-center justify-between">
        <span class="text-sm md:text-lg">{{ $title }}</span>

        @if ($closeBtn)
            <button x-on:click="show = false" class="text-gray-400 bg-gray-100 hover:bg-gray-200 rounded-full focus:outline-none p-2">
                <x-icons.cancel-icon/>
            </button>
        @endif
    </h1>

    <div class="max-h-96 overflow-hidden w-full">
        {{ $content }}
    </div>

    @isset($footer)
        <div class="px-6 py-4 bg-gray-100 text-right">
            {{ $footer }}
        </div>
    @endisset
</x-jet-modal>
