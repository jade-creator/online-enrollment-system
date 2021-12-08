<div class="">
    @auth
        @if (! is_null($batch) && $batch->progress() < 100)
            <section x-data="{ open: true }"
                     id="alert" class="fixed top-14 w-screen h-screen z-50 bg-gray-500 bg-opacity-25">
                <div x-show="open"
                     class="relative items-center w-11/12 md:w-1/2 py-5 md:py-2 mx-auto cursor-pointer">

                    <div class="p-6 -6 rounded-xl bg-green-50 relative shadow-2xl">
                        <div class="flex break-words">
                            <div class="flex-shrink-0 text-green-500 animate-pulse">
                                <x-icons.loading-icon color="#008000FF"/>
                                <span class="text-xs">{{ $batch->progress() ?? '' }}%</span>
                            </div>
                            <div class="ml-3 w-full">
                                <div class="text-sm text-green-600">
                                    {{ $batch->name ?? 'N/A' }} ({{ $batch->processedJobs() ?? '' }}/{{ $batch->totalJobs ?? '' }})
                                    <span class="text-gray-400 text-xs">Don't do other things please wait to finish.</span>
                                </div>
                                <progress style="width: 100%;" id="bar" value="{{ $batch->processedJobs() ?? '0' }}" max="{{ $batch->totalJobs ?? '0' }}"></progress>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <script>
                const setIntervalId = window.setInterval(function () {
                    window.livewire.emit('updateBatchId', '{{$batch->id}}')
                }, 2000);

                window.addEventListener('stop-interval', event => {
                    window.clearInterval(setIntervalId);
                });
            </script>
        @endif
    @endauth
</div>
