@props([ 'title', 'data', 'message' ])

<i class="far fa-check-circle mx-2 text-green-500"></i>
<div class="mt-0.5 text-left">
    <p class="font-bold text-sm">{{ $title }}</p>
    <p class="text-xs"><span class="font-bold">{{ $data }}</span>{{ $message }}</p>
</div>
<button @click="open = ! open" class="cursor-pointer ml-2 text-gray-400 focus:outline-none active:outline-none hover:opacity-50">
    <i class="fas fa-times font-medium"></i>
</button>