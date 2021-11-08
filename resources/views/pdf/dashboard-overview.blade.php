<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Overview</title>
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
    <div class="container">
        <table class="container-title">
            <tr>
                <td class="center truncate-widest">OVERVIEW</td>
            </tr>
        </table>
    </div>
    <div class="cards">
            <div class="card">
                <div class="card-text">
                    <p>Users</p>
                    <p>{{ $users }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-text">
                    <p>Pre Registrations</p>
                    <p>{{ $registrations }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-text">
                    <p>Sections</p>
                    <p>{{ $sections }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-text">
                    <p>Subjects</p>
                    <p>{{ $subjects }}</p>
                </div>
            </div>
    </div>
    <div class="container">
        <table class="ordinary-table">
            <tr>
                <th class="left text-primary">
                    <p class="pl-1">Gender</p>
                    <p class="lighter text-gray size-14 pl-1">Total number per gender category in the system</p>
                </th>
                <td>
                    <table>
                        <tr>
                            <th>Female</th>
                            <td class="right w-one-fourth">{{ $female }}</td>
                        </tr>
                        <tr>
                            <th>Male</th>
                            <td class="right w-one-fourth">{{ $male }}</td>
                        </tr>
                        <tr>
                            <th>Other</th>
                            <td class="right w-one-fourth">{{ $other }}</td>
                        </tr>
                        <tr>
                            <th>Prefer not to say</th>
                            <td class="right w-one-fourth">{{ $prefer }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th class="left text-primary">
                    <p class="pl-1">Users</p>
                    <p class="lighter text-gray size-14 pl-1">Total number of registered users</p>
                </th>
                <td>
                    <table>
                        <tr>
                            <th>Admin</th>
                            <td class="right w-one-fourth">{{ $admin }}</td>
                        </tr>
                        <tr>
                            <th>Student</th>
                            <td class="right w-one-fourth">{{ $student }}</td>
                        </tr>
                        <tr>
                            <th>Registrar</th>
                            <td class="right w-one-fourth">{{ $registrar }}</td>
                        </tr>
                        <tr>
                            <th>Dean</th>
                            <td class="right w-one-fourth">{{ $dean }}</td>
                        </tr>
                        <tr>
                            <th>Faculty Members</th>
                            <td class="right w-one-fourth">{{ $faculty }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th class="left text-primary">
                    <p class="pl-1">Registration Status</p>
                    <p class="lighter text-gray size-14 pl-1">Total number registration per status</p>
                </th>
                <td>
                    <table>
                        <tr>
                            <th>Enrolled</th>
                            <td class="right w-one-fourth">{{ $enrolled }}</td>
                        </tr>
                        <tr>
                            <th>Finalized</th>
                            <td class="right w-one-fourth">{{ $finalized }}</td>
                        </tr>
                        <tr>
                            <th>Confirming</th>
                            <td class="right w-one-fourth">{{ $confirming }}</td>
                        </tr>
                        <tr>
                            <th>Pending</th>
                            <td class="right w-one-fourth">{{ $pending }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <h4>{{ "Number of students per program as of SY. ".\Carbon\Carbon::parse(now())->format('Y').'-'.\Carbon\Carbon::parse(now())->addYear()->format('Y') }}</h4>
    <table>
        @foreach ($programsData as $programs)
            <tr>
                @foreach ($programs as $code => $data)
                    <td>
                        <div class="" style="width: 170px; height: 60px; margin-bottom: 5.5px; background: white; border-radius: 0.5rem; border: 1px solid rgb(197, 197, 197); position: relative;">
                            <div style="position: absolute; left: 15px; top: 12px;">
                                <p style="font-weight: lighter; text-transform: uppercase; letter-spacing: 1px; font-size: 10px;">{{ $code }}</p>
                                <p style="margin-top: 5px; font-weight: 700; color: rgba(99, 102, 241, 1);">{{ $data }}</p>
                            </div>
                        </div>
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>

    <footer>
        <p>{{ Carbon\Carbon::parse(now())->format('F j, Y') }}</p>
        <p>{{ $school_address ?? 'N/A' }} | Visit us: {{ env('APP_URL', 'university-ph.herokuapp.com') ?? 'N/A' }}</p>
    </footer>
</body>
</html>
