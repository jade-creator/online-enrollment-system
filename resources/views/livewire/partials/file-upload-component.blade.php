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
                <div class="flex gap-2 items-center">
                    <input type="file" wire:model="files" multiple>
                    <div wire:target="files" wire:loading>
                        <x-icons.loading-icon color="rgba(99, 102, 241, 1)" />
                    </div> 
                </div>
                <x-jet-input-error for="files" class="mt-2" />
            </div>
            @forelse ($user->files as $file)
                <div class="col-span-6 border border-gray-200 p-2 rounded-md flex items-center justify-between">
                    <p class="truncate w-9/12">{{ $file->file_name }}</p>
                    <div class="space-x-2">
                        <button wire:click.prevent="download({{$file}})" class="hover:text-green-500">
                            <x-icons.export-icon/>
                        </button>
                        <button wire:click.prevent="removeConfirm({{$file}})" class="p-1 rounded-md hover:bg-red-500 hover:text-white transition-colors">
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

            <x-jet-button class="bg-indigo-700 hover:bg-indigo-800" wire:loading.attr="disabled" wire:target="files">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
