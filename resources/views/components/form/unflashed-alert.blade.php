@props(['type' => ''])

@php
    $borderColor = '';
    $bgColor = '';
    $lightTextColor = '';
    $darkTextColor = '';

    if (isset($type)) {
        switch ($type) {
            case 'success':
                $borderColor = 'border-green-500';
                $bgColor = 'bg-green-50';
                $lightTextColor = 'text-green-400';
                $darkTextColor = 'text-green-600';
                break;

            case 'info':
                $borderColor = 'border-blue-500';
                $bgColor = 'bg-blue-50';
                $lightTextColor = 'text-blue-400';
                $darkTextColor = 'text-blue-600';
                break;

            case 'danger':
                $borderColor = 'border-red-500';
                $bgColor = 'bg-red-50';
                $lightTextColor = 'text-red-400';
                $darkTextColor = 'text-red-600';
                break;

            default:
                $borderColor = 'border-yellow-500';
                $bgColor = 'bg-yellow-50';
                $lightTextColor = 'text-yellow-400';
                $darkTextColor = 'text-yellow-600';
                break;
        }
    }
@endphp

<section>
    <div class="relative items-center w-full max-w-7xl">
        <!------ Component-->
        <div class="p-6 border-2 {{$borderColor}} rounded-md {{$bgColor}}">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 {{$lightTextColor}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        @if ($type == 'success')
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        @elseif ($type == 'info')
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        @elseif ($type == 'danger')
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        @else
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        @endif
                    </svg>
                </div>
                <div class="ml-3">
                    <div class="text-sm {{$darkTextColor}}">
                        <p class="">@isset($slot){!! $slot !!}@endisset</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
