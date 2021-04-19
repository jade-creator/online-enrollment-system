@if ($errors->any())
    <div {{ $attributes }}>
        <div x-data="{ open: true }" :class="{'hidden': ! open, 'block': open }" class="bg-red-100 p-5 py-3 border border-red-200 rounded-md">
            <div class="flex justify-between">
                <div class="font-bold text-red-400">{{ __('Warning!') }}</div>
                <button @click="open = ! open" class="focus:outline-none active:outline-none text-red-400 hover:text-red-300">
                    <i class="fas fa-times font-medium"></i>
                </button>
            </div>

            <ul class="mt-1 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
