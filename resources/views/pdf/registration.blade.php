<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $registration->student->user->person->full_name ?? 'N/A' }}</title>
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
                <td>Pre Registration Info</td>
                <td>{{ $registration->created_at->format('F j, Y') ?? 'N/A' }}</td>
            </tr>
        </table>
        <table class="container-details">
                <tr>
                    <td>Registration ID: <span>{{ $registration->custom_id ?? 'N/A' }}</span></td>
                    <td>Status: <span>{{ $registration->status->name ?? 'N/A' }}</span></td>
                </tr>
                <tr>
                    <td>Level: <span>{{ $registration->prospectus->level->level ?? 'N/A' }}</span></td>
                    <td>Program: <span>{{ $registration->prospectus->program->code ?? 'N/A' }}</span></td>
                </tr>
                <tr>
                    <td>Semester: <span>{{ $registration->prospectus->term->term ?? 'N/A' }}</span></td>
                    <td>School Year: <span>{{ $registration->school_year ?? 'N/A' }}</span></td>
                </tr>
                <tr>
                    <td>Section: <span>{{ $registration->section->name ?? 'N/A' }}</span></td>
                </tr>
        </table>
    </div>

    <div class="container">
        <table class="container-title">
            <tr>
                <td>Student Details</td>
            </tr>
        </table>
        <table class="container-details">
            <tr>
                <td>Student ID: <span>{{ $registration->student->custom_id ?? 'N/A' }}</span></td>
                <td>Type: <span>{{ $registration->isNew ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td>Name: <span>{{ $registration->student->user->person->full_name ?? 'N/A' }}</span></td>
                <td>Email: <span>{{ $registration->student->user->email ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td>Mobile Number: <span>{{ $registration->student->user->person->contact->mobile_number ?? 'N/A' }}</span></td>
                <td>Address: <span>{{ $registration->student->user->person->contact->address ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td>Birthdate: <span>{{ \Carbon\Carbon::parse($registration->student->user->person->detail->birthdate)->format('F j, Y') ?? 'N/A' }}</span></td>
                <td>Birthplace: <span>{{ $registration->student->user->person->detail->birthplace ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td>Gender: <span>{{ $registration->student->user->person->detail->gender ?? 'N/A' }}</span></td>
                <td>Civil Status: <span>{{ $registration->student->user->person->detail->civil_status ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td>Religion: <span>{{ $registration->student->user->person->detail->religion ?? 'N/A' }}</span></td>
                <td>Nationality: <span>{{ $registration->student->user->person->detail->country->name ?? 'N/A' }}</span></td>
            </tr>
        </table>
    </div>

    <div class="container">
        <table class="container-title">
            <tr>
                <td>Class Schedules</td>
                <td>Total Units: {{ $totalUnit ?? 'N/A' }}</td>
            </tr>
        </table>
        <table class="container-details">
            <tr>
                <th>Code</th>
                <th>Title</th>
                <th>Professor</th>
                <th>Day</th>
                <th>Time</th>
                <th>Unit</th>
            </tr>

            @isset ($prospectus_subjects)
                @forelse ($prospectus_subjects  as $subjects)
                    @foreach ($subjects as $start_times)
                        @foreach ($start_times as $end_times)
                            @foreach ($end_times as $employees)
                                @foreach ($employees as $schedules)
                                    @foreach ($schedules->sortBy('day_id', SORT_REGULAR, false) as $schedule)
                                        @if ($loop->first)
                                            <tr>
                                                <td class="center">{{ $schedule->prospectusSubject->subject->code ?? 'N/A' }}</td>
                                                <td class="center">{{ $schedule->prospectusSubject->subject->title ?? 'N/A' }}</td>
                                                <td class="center">{{ $schedule->employee->user->person->full_name ?? 'N/A' }}</td>
                                                <td class="center">
                                                    @foreach ($schedules->sortBy('day_id', SORT_REGULAR, false) as $schedule)
                                                        {{$loop->first ? '' : ','}}
                                                        <span>{{$schedule->day->short_abbrev ?? 'N/A'}}</span>
                                                    @endforeach
                                                </td>
                                                <td class="center">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i a') ?? 'N/A' }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i a') ?? 'N/A' }}</td>
                                                <td class="center">{{ $schedule->prospectusSubject->unit ?? 'N/A' }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                @empty
                    <p>No result found.</p>
                @endforelse
            @endisset
        </table>
    </div>

    <div class="double-container">
        <div class="left-container">
            <table class="container-title">
                <tr>
                    <td>Assessment</td>
                    <td>Total: {{ $registration->assessment->getFormattedPriceAttribute($registration->assessment->grand_total) ?? 'N/A' }}</td>
                </tr>
            </table>
            <table class="container-details">
                @foreach ($registration->fees as $index => $fee)
                    <tr>
                        <td>{{ $fee->category->name ?? 'N/A' }}</td>
                        <td>{{ $fee->getFormattedPriceAttribute($fee->formatTwoDecimalPlaces($fee->pivot->total_fee)) ?? 'N/A' }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>Additional Fee</td>
                    <td>{{ $registration->assessment->getFormattedPriceAttribute($registration->assessment->additional) ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Discount Type</td>
                    <td>
                        @isset ($registration->assessment->isPercentage)
                            {{ $registration->assessment->discount_type ?? 'N/A' }}
                        @else
                            N/A
                        @endisset
                    </td>
                </tr>
                <tr>
                    <td>Discount Amount</td>
                    <td>{{ $registration->assessment->discount_amount ?? 'N/A' }}<</td>
                </tr>
                <tr>
                    <td>Remarks</td>
                    <td>{{ $registration->assessment->remarks ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Total Amount</td>
                    <td>{{ $registration->assessment->getFormattedPriceAttribute($registration->assessment->grand_total) ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
        <div class="right-container">
            <div id="signatures">
                <h4>Present this certificate for any transaction within the University.</h6>
                <p>Student Signature</p>
                <p>Approved By:</p>
            </div>
        </div>
    </div>

    <footer>
        <p>{{ Carbon\Carbon::parse(now())->format('F j, Y') }}</p>
        <p>Pasig City, Metro Manila 1600 | Visit us: university.edu.ph</p>
    </footer>
</body>
</html>
