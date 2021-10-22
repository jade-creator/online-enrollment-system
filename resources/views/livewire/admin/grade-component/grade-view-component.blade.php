<x-table.nested-row>
    <x-slot name="nestedTable">
        <div class="hidden md:grid grid-cols-12 gap-2 p-4 bg-indigo-500">
            <x-table.column-title class="col-span-1"><span class="text-white">code</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">title</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">section</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">semester</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">grade</span></x-table.column-title>
            <x-table.column-title class="col-span-2"><span class="text-white">remark</span></x-table.column-title>
            <x-table.column-title class="col-span-1"><span class="text-white">action</span></x-table.column-title>
        </div>

        <livewire:admin.grade-component.row-blade-component :registration="$registration" :grades="$registration->grades" key="'row-blade-component-'{{ $registration->id.now() }}">

        @if ($registration->extensions->isNotEmpty())
            @foreach ($registration->extensions as $extension)
                <livewire:admin.grade-component.row-blade-component :registration="$extension->registration" :grades="$extension->registration->grades" key="'row-blade-component-'{{ $registration->id.now() }}">
            @endforeach
        @endif
    </x-slot>
</x-table.nested-row>
