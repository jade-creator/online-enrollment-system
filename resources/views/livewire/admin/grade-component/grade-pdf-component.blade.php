<div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
    @if (isset($registration))
        <div class="py-10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-bold text-lg"><span class="capitalize">{{ $registration->student->user->person->full_name ?? 'N/A' }}</span> - Grade Report</p>
                    <a href="{{ route('pre.registration.view', $registration->id) }}" title="View Details">
                        <p class="text-indigo-500 font-bold hover:underline text-sm">REGISTRATION ID: <span>{{ $registration->custom_id ?? 'N/A' }}</span></p>
                    </a>
                </div>
                <x-jet-button wire:click="createPdf" wire:loading.attr="disabled" class="bg-indigo-700 hover:bg-indigo-800 flex items-end">
                    <x-icons.export-icon/>
                    <span>{{ __('Export as PDF')}}</span>
                </x-jet-button>
            </div>
            <x-jet-section-border/>
        </div>

        <table>
            <tr>
                <th>
                    <input wire:model="selectAll" wire:loading.attr="disabled" type="checkbox" name="selectAll">
                </th>
                <th>subject</th>
                <th>title</th>
                <th>section</th>
                <th>grade</th>
                <th>remark</th>
            </tr>
            <tbody>
                @forelse ($registration->grades as $grade)
                   <tr>
                       <td>
                           <input wire:model="grades.{{ $loop->index }}.0" wire:loading.attr="disabled" type="checkbox" name="grades[{{ $loop->index }}][0]">
                       </td>
                       <td>{{ $grade->prospectus_subject->subject->code ?? 'N/A' }}</td>
                       <td>{{ $grade->prospectus_subject->subject->title ?? 'N/A' }}</td>
                       <td>{{ $registration->section->name ?? 'N/A' }}</td>
                       <td>{{ $grade->value ?? 'N/A' }}</td>
                       <td>{{ $grade->mark->name ?? 'N/A' }}</td>
                   </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        <p>Computed Grade: <span>{{ number_format($this->grade, '2', '.', '') ?? 'N/A' }}</span></p>
    @endisset
</div>
