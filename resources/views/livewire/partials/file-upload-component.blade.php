<div>
    <x-jet-form-section submit="save">
        <x-slot name="title">
            {{ __('File Upload') }}
        </x-slot>

        <x-slot name="description">
             {{ __('Please upload required/additional file/s.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                <x-jet-label for="files" value="{{ __('Files') }}" />
                <input type="file" wire:model="files" multiple>
                <x-jet-input-error for="files" class="mt-2" />
            </div>
            @forelse ($user->files as $file)
                <div class="col-span-6 border border-gray-200 px-2 py-3 rounded-md flex items-center justify-between">
                    <p>{{ $file->file_name }}</p>
                    <div>
                        <button wire:click.prevent="download({{$file}})">
                            <x-icons.export-icon/>
                        </button>
                        <button wire:click.prevent="removeConfirm({{$file}})">
                            <x-icons.delete-icon/>
                        </button>
                    </div>
                </div>
            @empty
            @endforelse
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3 text-green-500 font-bold" on="saved">
                {{ __('Saved successfuly!') }}
            </x-jet-action-message>

            <x-jet-button class="bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled" wire:target="photo">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
