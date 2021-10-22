<div class="p-2">
    <h3 class="font-semibold">{{ __('Programs')}}</h3>
    <ul x-data="{ program: 'none', open: false }" id="program-wrapper">
        @forelse($programs as $program)
            <li @click.stop="program = '{{$program->code}}'" class="flex items-center p-2 hover:bg-gray-100 cursor-pointer">
                <span @click.stop="program = 'none'" :class="{ 'rotate-90': program === '{{$program->code}}', 'rotate-0': program !== '{{$program->code}}'}" class="transform transition-transform">
                    <x-icons.right-arrow-icon/>
                </span>
                <span class="px-2">{{ $program->code }}</span>
            </li>
            <li :class="{ 'block': open, 'hidden': open }" class="pl-12 py-2 bg-gray-50 cursor-pointer">
                @forelse($program->prospectuses as $prospectus)
                    @if($loop->odd)
                        <h5 class="my-2 text-sm text-indigo-500 font-bold">{{$prospectus->level->level}}</h5>
                    @endif

                    <div class="border border-indigo-500 border-opacity-0 hover:border-opacity-100" >
                        @if (auth()->user()->role->name == 'admin')
                            <a href="{{ route('admin.prospectuses.view', ['prospectusId' => $prospectus->id, 'curriculumId' => $curriculumId]) }}">
                                <h4 class="pl-4 py-1">{{$prospectus->term->term}}</h4>
                            </a>
                        @elseif (auth()->user()->role->name == 'student')
                            <a href="{{ route('student.grades.view', ['prospectusId' => $prospectus->id]) }}">
                                <h4 class="pl-4 py-1">{{$prospectus->term->term}}</h4>
                            </a>
                        @endif
                    </div>
                @empty
                @endforelse
            </li>
        @empty
        @endforelse
    </ul>
</div>
