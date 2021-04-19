<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150']) }} wire:loading.attr="disabled">
    {{ $slot }}
</button>
