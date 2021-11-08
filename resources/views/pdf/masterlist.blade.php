<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Masterlist S.Y. {{\Carbon\Carbon::parse(now())->format('Y').'-'.\Carbon\Carbon::parse(now())->addYear()->format('Y')}}</title>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>

<body>
    <div class="watermark" style="background-image: url({{$school_profile_photo_path}})"></div>
    <div class="logo-container mb-3 center">
        <img src="{{ $school_profile_photo_path }}" alt="logo" width="50" height="50"/>
        <p class="truncate-widest bold">{{ $school_name ?? env('APP_NAME', 'University') }}</p>
        <p>{{ $school_address }}</p>
    </div>

    <div class="container" style="padding-top: 10px;">
        @foreach ($masterlist as $faculty)
            <p style="text-align: center; text-transform: uppercase; width: 100%; margin-bottom: 20px; font-weight: bolder">{{ $faculty->name ?? 'N/A' }}</p>

            @foreach ($faculty->programs as $program)
                @foreach ($program->prospectuses as $prospectus)
                    @if ($prospectus->registrations->isNotEmpty())
                        @if ($loop->first)
                            <p style="text-align: left; width: 100%; margin-bottom: 20px; margin-top: 50px; font-weight: bolder;">
                                {{ $program->program ?? 'N/A' }} - S.Y. {{\Carbon\Carbon::parse(now())->format('Y').'-'.\Carbon\Carbon::parse(now())->addYear()->format('Y')}}
                            </p>
                        @endif

                        <table class="container-title">
                            <tr>
                                <td class="center truncate-widest">
                                    {{$prospectus->level->level ?? 'N/A'}} | {{$prospectus->term->term ?? 'N/A'}}
                                </td>
                            </tr>
                        </table>

                        <table class="ordinary-table" style="margin-bottom: 50px;">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Section</th>
                                <th>Status</th>
                            </tr>
                            @foreach ($prospectus->registrations->sortBy('student.user.person.lastname', SORT_REGULAR, false) as $registration)
                                <tr>
                                    <td class="center">{{ $registration->student->custom_id ?? 'N/A' }}</td>
                                    <td>{{ $registration->student->user->person->short_full_name_reversed ?? 'N/A' }}</td>
                                    <td>{{ $registration->section->name ?? 'N/A' }}</td>
                                    <td class="center">{{ ucfirst($registration->status->name) ?? 'N/A' }}/{{ ucfirst($registration->classification) ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                @endforeach
            @endforeach
        @endforeach
    </div>

    <footer>
        <p>{{ Carbon\Carbon::parse(now())->format('F j, Y') }}</p>
        <p>{{ $school_address ?? 'N/A' }} | Visit us: {{ env('APP_URL', 'university-ph.herokuapp.com') ?? 'N/A' }}</p>
    </footer>
</body>
</html>
