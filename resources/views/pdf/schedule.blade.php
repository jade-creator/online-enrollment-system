<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Schedule</title>
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
    <style>
        /*PDF SIZE*/
        @page { size: 20cm 30cm landscape; }
    </style>
</head>

<body>
    <div class="watermark" style="background-image: url({{$school_profile_photo_path}})"></div>
    <div class="logo-container mb-3 center">
        <img src="{{ $school_profile_photo_path }}" alt="logo" width="50" height="50"/>
        <p class="truncate-widest bold">{{ $school_name ?? env('APP_NAME', 'University') }}</p>
        <p>{{ $school_address }}</p>
    </div>

    <div class="mb-4 container">
        <table class="container-title">
            <tr>
                <td class="center truncate-widest">BSIT4E SCHEDULE</td>
            </tr>
        </table>
        <table class="ordinary-table">
            <tr>
                <th width="125">Time</th>
                @foreach($weekDays as $day)
                    <th>{{ $day->name ?? 'N/A' }}</th>
                @endforeach
            </tr>
            @foreach ($calendarData as $time => $days)
                <tr>
                    <td class="center">
                        {{ \Carbon\Carbon::parse(substr($time, 0, 5))->format('h:ia').' - '.\Carbon\Carbon::parse(substr($time, 6))->format('h:ia') }}
                    </td>
                    @foreach($days as $value)
                        @if (is_array($value))
                            <td rowspan="{{ $value['rowspan'] }}" class="center" style="background-color:#f0f0f0">
                                {{ $value['class_name'] }}<br>
                                Faculty: {{ $value['teacher_name'] }}
                            </td>
                        @elseif ($value === 1)
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>

    <footer>
        <p>{{ Carbon\Carbon::parse(now())->format('F j, Y') }}</p>
        <p>Pasig City, Metro Manila 1600 | Visit us: university.edu.ph</p>
    </footer>
</body>
</html>
