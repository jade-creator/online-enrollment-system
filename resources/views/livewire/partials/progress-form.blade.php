<div class="w-full xl:w-56 mt-5">
    <div class="hidden xl:block">
        <div class="flex">
            <svg class="{{ $step > 1 ? 'm-3 h-6 bg-green-400 p-1 rounded-xl' : 'm-3 h-6 bg-gray-300 p-1 rounded-xl'}}" viewBox="0 0 20 20">
                <path fill="white" d="M7.197,16.963H7.195c-0.204,0-0.399-0.083-0.544-0.227l-6.039-6.082c-0.3-0.302-0.297-0.788,0.003-1.087
                C0.919,9.266,1.404,9.269,1.702,9.57l5.495,5.536L18.221,4.083c0.301-0.301,0.787-0.301,1.087,0c0.301,0.3,0.301,0.787,0,1.087
                L7.741,16.738C7.596,16.882,7.401,16.963,7.197,16.963z"></path>
            </svg>
            <h1 class="{{ $step > 1 ? 'mt-3 text-gray-600 font-bold' : 'mt-3 text-gray-300 font-bold'}}">Fullname</h1>
        </div>
        <div class="flex">
            <svg class="{{ $step > 2 ? 'm-3 h-6 bg-green-400 p-1 rounded-xl' : 'm-3 h-6 bg-gray-300 p-1 rounded-xl'}}" viewBox="0 0 20 20">
                <path fill="white" d="M7.197,16.963H7.195c-0.204,0-0.399-0.083-0.544-0.227l-6.039-6.082c-0.3-0.302-0.297-0.788,0.003-1.087
                C0.919,9.266,1.404,9.269,1.702,9.57l5.495,5.536L18.221,4.083c0.301-0.301,0.787-0.301,1.087,0c0.301,0.3,0.301,0.787,0,1.087
                L7.741,16.738C7.596,16.882,7.401,16.963,7.197,16.963z"></path>
            </svg>
            <h1 class="{{ $step > 2 ? 'mt-3 text-gray-600 font-bold' : 'mt-3 text-gray-300 font-bold'}}">Other Details</h1>
        </div>
        <div class="flex">
            <svg class="{{ $step > 3 ? 'm-3 h-6 bg-green-400 p-1 rounded-xl' : 'm-3 h-6 bg-gray-300 p-1 rounded-xl'}}" viewBox="0 0 20 20">
                <path fill="white" d="M7.197,16.963H7.195c-0.204,0-0.399-0.083-0.544-0.227l-6.039-6.082c-0.3-0.302-0.297-0.788,0.003-1.087
                C0.919,9.266,1.404,9.269,1.702,9.57l5.495,5.536L18.221,4.083c0.301-0.301,0.787-0.301,1.087,0c0.301,0.3,0.301,0.787,0,1.087
                L7.741,16.738C7.596,16.882,7.401,16.963,7.197,16.963z"></path>
            </svg>
            <h1 class="{{ $step > 3 ? 'mt-3 text-gray-600 font-bold' : 'mt-3 text-gray-300 font-bold'}}">Contact</h1>
        </div>
    
        @if (auth()->user()->role->name == 'student')
            <div class="flex">
                <svg class="{{ $step > 4 ? 'm-3 h-6 bg-green-400 p-1 rounded-xl' : 'm-3 h-6 bg-gray-300 p-1 rounded-xl'}}" viewBox="0 0 20 20">
                    <path fill="white" d="M7.197,16.963H7.195c-0.204,0-0.399-0.083-0.544-0.227l-6.039-6.082c-0.3-0.302-0.297-0.788,0.003-1.087
                    C0.919,9.266,1.404,9.269,1.702,9.57l5.495,5.536L18.221,4.083c0.301-0.301,0.787-0.301,1.087,0c0.301,0.3,0.301,0.787,0,1.087
                    L7.741,16.738C7.596,16.882,7.401,16.963,7.197,16.963z"></path>
                </svg>
                <h1 class="{{ $step > 4 ? 'mt-3 text-gray-600 font-bold' : 'mt-3 text-gray-300 font-bold'}}">Guardian</h1>
            </div>
            <div class="flex">
                <svg class="{{ $step > 5 ? 'm-3 h-6 bg-green-400 p-1 rounded-xl' : 'm-3 h-6 bg-gray-300 p-1 rounded-xl'}}" viewBox="0 0 20 20">
                    <path fill="white" d="M7.197,16.963H7.195c-0.204,0-0.399-0.083-0.544-0.227l-6.039-6.082c-0.3-0.302-0.297-0.788,0.003-1.087
                    C0.919,9.266,1.404,9.269,1.702,9.57l5.495,5.536L18.221,4.083c0.301-0.301,0.787-0.301,1.087,0c0.301,0.3,0.301,0.787,0,1.087
                    L7.741,16.738C7.596,16.882,7.401,16.963,7.197,16.963z"></path>
                </svg>
                <h1 class="{{ $step > 5 ? 'mt-3 text-gray-600 font-bold' : 'mt-3 text-gray-300 font-bold'}}">Education</h1>
            </div>
        @endif
    </div>

    <div class="block xl:hidden px-4 sm:px-4 lg:px-8 w-full">
        <div class="font-bold flex flex-row justify-between">
            <p>Progress:</p>
            <p><span> {{ $step > 1 ? $step-=1 : '0' }}</span> / {{ Auth::user()->role->name === 'admin' ? 3 : 5}}</p>
        </div>
    </div>
</div>


