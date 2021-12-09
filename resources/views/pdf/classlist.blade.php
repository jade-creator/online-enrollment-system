<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $section->name.'-'.$section->prospectus->term->term ?? 'Print ' }} - Classlist</title>
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
    <div class="container" style="margin-top: 5px;">
        <table>
            <tr>
                <th style="color: rgba(99, 102, 241, 1); text-align: left">
                    Course Instructor:
                </th>
                <th style="color: rgba(99, 102, 241, 1); text-align: left">
                    Course/Subject:
                </th>
            </tr>
            <tr>
                <th style="text-align: left">
                    Prof. {{ $employee->user->person->full_name ?? 'N/A' }}
                </th>
                <th style="text-align: left">
                    {{ $prospectusSubject->subject->code ?? 'N/A' }}
                </th>
            </tr>
        </table>
    </div>
    <div class="container">
        <table class="container-title">
            <tr>
                <td class="center truncate-widest uppercase">CLASSLIST - {{$section->name ?? 'N/A'}}</td>
            </tr>
        </table>
        <table class="ordinary-table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
            </tr>

            @forelse ($registrations as $registration)
                <tr>
                    <td class="center">{{ $registration->student->custom_id ?? 'N/A' }}</td>
                    <td>{{ $registration->student->user->person->full_name ?? 'N/A' }}</td>
                    <td class="center" style="text-transform: uppercase">{{ $registration->status->name ?? 'N/A' }}/{{ $registration->classification ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td rowspan="4">No result found.</td>
                </tr>
            @endforelse
        </table>
    </div>

    <footer>
        <p>{{ Carbon\Carbon::parse(now())->format('F j, Y') }}</p>
        <p>{{ $school_address ?? 'N/A' }} | Visit us: {{ env('APP_URL', 'university-ph.herokuapp.com') ?? 'N/A' }}</p>
    </footer>
</body>
</html>
