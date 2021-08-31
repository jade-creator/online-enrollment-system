<div class="pb-2">
    <h3 class="font-bold text-md px-4">{{ __('Programs')}}</h3>
    <ul x-data="{ program: 'none' }" id="program-wrapper">
        @forelse($programs as $program)
            <li @click.stop="program = '{{$program->code}}'" class="flex items-center p-2 hover:bg-gray-100 cursor-pointer">
                <span @click.stop="program = 'none'" :class="{ 'rotate-90': program === '{{$program->code}}', 'rotate-0': program !== '{{$program->code}}'}" class="transform">
                    <x-icons.right-arrow-icon/>
                </span>
                <span class="px-2">{{ $program->code }}</span>
            </li>
            <li :class="{ 'block': program === '{{$program->code}}', 'hidden': program !== '{{$program->code}}'}" class="px-4 py-2 bg-gray-200 cursor-pointer">
                @forelse($program->prospectuses as $prospectus)
                    @if($loop->odd)
                        <h5 class="text-sm text-indigo-500 font-bold">{{$prospectus->level->level}}</h5>
                    @endif
                    <a href="{{ route('prospectuses.view', ['prospectusId' => $prospectus->id]) }}">
                        <h4 class="pl-4 py-1">{{$prospectus->term->term}}</h4>
                    </a>
                @empty
                @endforelse
            </li>
        @empty
        @endforelse
    </ul>
</div>
