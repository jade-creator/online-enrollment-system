<x-table.nested-row>
    <x-slot name="nestedTable">
        <div class="hidden md:grid py-4 grid-cols-12 gap-2">
            <x-table.column-title class="col-span-2 text-blue-500">subject</x-table.column-title>
            <x-table.column-title class="col-span-2">title</x-table.column-title>
            <x-table.column-title class="col-span-2">section</x-table.column-title>
            <x-table.column-title class="col-span-2">semester</x-table.column-title>
            <x-table.column-title class="col-span-2">grade</x-table.column-title>
            <x-table.column-title class="col-span-1">remark</x-table.column-title>
            <x-table.column-title class="col-span-1">action</x-table.column-title>
        </div>

        <livewire:admin.grade-component.row-blade-component :registration="$registration" :grades="$registration->grades" key="'row-blade-component-'{{ $registration->id.now() }}">

        @if ($registration->extensions->isNotEmpty())
            @foreach ($registration->extensions as $extension)
                <livewire:admin.grade-component.row-blade-component :registration="$extension->registration" :grades="$extension->registration->grades" key="'row-blade-component-'{{ $registration->id.now() }}">
            @endforeach
        @endif
    </x-slot>
</x-table.nested-row>
