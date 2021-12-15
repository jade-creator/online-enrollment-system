<div class="col-span-6 grid grid-cols-6">
    <button wire:click.prevent="payConfirm"
            class="bg-indigo-500 hover:bg-indigo-700 col-span-6 mt-4 py-2.5 text-white text-lg font-semibold rounded-md flex items-center justify-center"
            @cannot('cash', \App\Models\Transaction::class)
                disabled="disabled"
                title="Please contact us at {{$school_email}}"
            @endcannot>
        <span class="block">Cash</span>
    </button>
</div>
