<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$curriculum->program->code ?? 'N/A'}} | {{$curriculum->code ?? 'N/A'}}</title>
    <link rel="icon" href="{{ $school_profile_photo_path }}">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>

<body>
<div class="watermark" style="background-image: url({{$school_profile_photo_path}})"></div>
<div class="logo-container mb-3 center">
    <img src="{{ $school_profile_photo_path }}" alt="logo" width="50" height="50"/>
    <p class="truncate-widest bold">{{ $school_name ?? env('APP_NAME', 'University') }}</p>
    <p>{{ $school_address }}</p>
</div>

<div class="container" style="font-size: 12px;">
    <table class="">
        <tr>
            <td class="center truncate-widest">
                {{$curriculum->program->code ?? 'N/A'}} | {{$curriculum->code ?? 'N/A'}}
            </td>
        </tr>
    </table>
</div>

@foreach ($curriculum->program->prospectuses as $prospectus)
    <div class="container" style="font-size: 12px;">
        <table class="container-title">
            <tr>
                <td class="center truncate-widest uppercase">{{ $prospectus->level->level ?? 'N/A' }} - {{$prospectus->term->term ?? 'N/A'}}</td>
            </tr>
        </table>
        <table class="ordinary-table">
            <tr>
                <th>code</th>
                <th>title</th>
                <th>description</th>
                <th>unit</th>
                <th>co-requisite</th>
                <th>pre-requisite</th>
            </tr>

            @forelse ($prospectus->subjects as $prospectusSubject)
                <tr>
                    <td>{{ $prospectusSubject->subject->code ?? 'N/A' }}</td>
                    <td>{{ $prospectusSubject->subject->title ?? 'N/A' }}</td>
                    <td>{{ $prospectusSubject->subject->description ?? 'N/A' }}</td>
                    <td>{{ $prospectusSubject->unit ?? 'N/A' }}</td>
                    <td>
                        @forelse ($prospectusSubject->corequisites as $subject)
                            {{ $loop->first ? '' : ', '  }}
                            {{ $subject->code }}
                        @empty
                            N/A
                        @endforelse
                    </td>
                    <td>
                        @forelse ($prospectusSubject->prerequisites as $subject)
                            {{ $loop->first ? '' : ', '  }}
                            {{ $subject->code }}
                        @empty
                            N/A
                        @endforelse
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No result found.</td>
                </tr>
            @endforelse
        </table>
    </div>
@endforeach

<footer>
    <p>{{ Carbon\Carbon::parse(now())->format('F j, Y') }}</p>
    <p>{{ $school_address ?? 'N/A' }} | Visit us: {{ env('APP_URL', 'university-ph.herokuapp.com') ?? 'N/A' }}</p>
</footer>
</body>
</html>
