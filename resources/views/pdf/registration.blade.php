<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $registration->student->user->person->full_name ?? 'Print ' }} - Registration</title>
    <link rel="icon" href="{{ $school_profile_photo_path }}">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>

<body class="text-sm">
    <div class="watermark" style="background-image: url({{$school_profile_photo_path}})"></div>
    <div class="w-full relative border-bottom-dotted border-1 border-gray-500 mb-1 pb-2">
        <img src="{{ $school_profile_photo_path }}" alt="logo" width="50" height="50" class="block float-left" style="margin-right: 5px"/>
        <p class="truncate-wide bold text-lg" style="margin-top: 5px">{{ $school_name ?? env('APP_NAME', 'University') }}</p>
        <p class="text-gray-400">{{ $school_address }}</p>
        <p class="lighter italic absolute" style="top: 10px; right: 50px">{{ \Carbon\Carbon::parse($registration->updated_at)->format('F j, Y') }}</p>
    </div>

    <div class="w-full bg-indigo-500 text-white p-half bold">Pre Registration Info</div>

    <div class="w-full p-half mb-1">
        <table>
            <tr>
                <td class="bold">Registration ID:</td>
                <td>{{ $registration->custom_id ?? 'N/A' }}</td>
                <td class="bold">Status:</td>
                <td>{{ $registration->status->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="bold">Level:</td>
                <td>{{ $registration->prospectus->level->level ?? 'N/A' }}</td>
                <td class="bold">Program:</td>
                <td>{{ $registration->prospectus->program->code ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="bold">Semester:</td>
                <td>{{ $registration->prospectus->term->term ?? 'N/A' }}</td>
                <td class="bold">School Year:</td>
                <td>{{ $registration->school_year ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="bold">Section:</td>
                <td>{{ $registration->section->name ?? 'N/A' }}</td>
                <td class="bold">Total units:</td>
                <td>{{ $totalUnit ?? 'N/A' }}</td>
            </tr>
        </table>

        <div class="border-bottom-dotted border-1 border-gray-400 mt-half mb-half"></div>
    </div>

    <div class="w-full bg-indigo-500 text-white p-half bold">Student Details</div>

    <div class="w-full p-half mb-1">
        <table>
            <tr>
                <td class="bold">Student ID:</td>
                <td>{{ $registration->student->custom_id ?? 'N/A' }}</td>
                <td class="bold">Type:</td>
                <td>{{ $registration->isNew ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="bold">Name:</td>
                <td>{{ $registration->student->user->person->full_name ?? 'N/A' }}</td>
                <td class="bold">Email:</td>
                <td>{{ $registration->student->user->email ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="bold">Mobile Number:</td>
                <td>{{ $registration->student->user->person->contact->mobile_number ?? 'N/A' }}</td>
                <td class="bold">Address:</td>
                <td>{{ $registration->student->user->person->contact->address ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td colspan="4" class="border-1 border-gray-400 mt-half" style="border-top-style: dotted;">&nbsp;</td>
            </tr>
            <tr>
                <td class="bold">Birthdate:</td>
                <td>{{ \Carbon\Carbon::parse($registration->student->user->person->detail->birthdate)->format('F j, Y') ?? 'N/A' }}</td>
                <td class="bold">Birthplace:</td>
                <td>{{ $registration->student->user->person->detail->birthplace ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="bold">Gender:</td>
                <td>{{ $registration->student->user->person->detail->gender ?? 'N/A' }}</td>
                <td class="bold">Civil Status:</td>
                <td>{{ $registration->student->user->person->detail->civil_status ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="bold">Religion:</td>
                <td>{{ $registration->student->user->person->detail->religion ?? 'N/A' }}</td>
                <td class="bold">Nationality:</td>
                <td>{{ $registration->student->user->person->detail->country->name ?? 'N/A' }}</td>
            </tr>
        </table>

        <div class="border-bottom-dotted border-1 border-gray-400 mt-half"></div>
    </div>

    <div class="w-full bg-indigo-500 text-white p-half bold">Class Schedules</div>

    <div class="w-full p-half mb-1">
        <table class="table-border-bottom-dotted">
            <tr class="title">
                <td >Code</td>
                <td>Title</td>
                <td>Prof</td>
                <td >Section</td>
                <td >Semester</td>
                <td class="center">Day</td>
                <td>Time</td>
                <td class="center">Unit</td>
            </tr>

            @isset ($prospectus_subjects)
                @forelse ($prospectus_subjects  as $subjects)
                    @foreach ($subjects as $start_times)
                        @foreach ($start_times as $end_times)
                            @foreach ($end_times as $employees)
                                @foreach ($employees as $schedules)
                                    @foreach ($schedules->sortBy('day_id', SORT_REGULAR, false) as $schedule)
                                        @if ($loop->first)
                                            <tr style="border-bottom: 1px solid black; padding: 5px 3px;">
                                                <td>{{ $schedule->prospectusSubject->subject->code ?? 'N/A' }}</td>
                                                <td>{{ $schedule->prospectusSubject->subject->title ?? 'N/A' }}</td>
                                                <td>{{ $schedule->employee->user->person->full_name ?? 'N/A' }}</td>
                                                <td>{{ $schedule->section->name ?? 'N/A' }}</td>
                                                <td>{{ $schedule->section->prospectus->term->term ?? 'N/A' }}</td>
                                                <td class="center">
                                                    @foreach ($schedules->sortBy('day_id', SORT_REGULAR, false) as $schedule)
                                                        {{$loop->first ? '' : ','}}
                                                        <span>{{$schedule->day->short_abbrev ?? 'N/A'}}</span>
                                                    @endforeach
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i a') ?? 'N/A' }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i a') ?? 'N/A' }}</td>
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

    <div class="w-full relative">
        <div class="absolute" style="top: 0; left: 0; width: 50%;">
            <div class="w-full bg-indigo-500 text-white p-half bold">Assessment of Fees</div>

            <table>
                @foreach ($registration->fees as $index => $fee)
                    <tr>
                        <td class="bold pt-half">{{ $fee->category->name ?? 'N/A' }}</td>
                        <td class="right pt-half">{{ $fee->getFormattedPriceAttribute($fee->formatTwoDecimalPlaces($fee->pivot->total_fee)) ?? 'N/A' }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="bold pt-half">Additional Fee</td>
                    <td class="right pt-half">{{ $registration->assessment->getFormattedPriceAttribute($registration->assessment->additional) ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="bold pt-half">Discount Type</td>
                    <td class="right pt-half">
                        @isset ($registration->assessment->isPercentage)
                            {{ $registration->assessment->discount_type ?? 'N/A' }}
                        @else
                            N/A
                        @endisset
                    </td>
                </tr>
                <tr>
                    <td class="bold pt-half">Discount Amount</td>
                    <td class="right pt-half">{{ $registration->assessment->discount_amount ?? 'N/A' }}<</td>
                </tr>
                <tr>
                    <td class="bold pt-half">Remarks</td>
                    <td class="right pt-half">{{ $registration->assessment->remarks ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="border-1 border-gray-400 mt-half" style="border-top-style: dotted;">&nbsp;</td>
                </tr>
                @if ($registration->assessment->isUnifastBeneficiary)
                    <tr>
                        <td class="bold">UniFAST Scholarship</td>
                        <td class="right">{{ $registration->assessment->isUnifastRecepient ?? 'N/A' }}</td>
                    </tr>
                @else
                    <tr>
                        <td class="bold">Downpayment</td>
                        <td class="right">{{ $registration->assessment->getFormattedPriceAttribute($registration->assessment->downpayment) ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="bold pt-half">Due Date</td>
                        <td class="right pt-half">{{ Carbon\Carbon::parse($registration->assessment->downpayment_due_date)->format('F j, Y') ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="bold pt-half">{{ $registration->assessment->isFullPayment ? 'Full Payment' : 'Partial Payment' }}</td>
                        <td class="right pt-half">{{ $registration->assessment->getFormattedPriceAttribute($registration->assessment->amount_due) ?? 'N/A' }}</td>
                    </tr>
                    @if ($registration->assessment->isFullPayment)
                        <tr>
                            <td class="bold pt-half">Due Date</td>
                            <td class="right pt-half">{{ Carbon\Carbon::parse($registration->assessment->first_due_date)->format('F j, Y') ?? 'N/A' }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="bold pt-half">Midterm</td>
                            <td class="right pt-half">{{ Carbon\Carbon::parse($registration->assessment->first_due_date)->format('F j, Y') ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="bold pt-half">Finals</td>
                            <td class="right pt-half">{{ Carbon\Carbon::parse($registration->assessment->second_due_date)->format('F j, Y') ?? 'N/A' }}</td>
                        </tr>
                    @endif
                @endif
                <tr>
                    <td colspan="2" class="border-1 border-gray-400 mt-half" style="border-top-style: dotted;">&nbsp;</td>
                </tr>
                <tr>
                    <td class="bold text-base">Total Amount</td>
                    <td class="right text-base">{{ $registration->assessment->getFormattedPriceAttribute($registration->assessment->grand_total) ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
        <div class="absolute container" style="top: 0; right: 0; width: 45%;">
            <table>
                <tr class="title">
                    <td class="center">
                        <img src="{{ $school_profile_photo_path }}" alt="logo" width="100" height="100" style=""/>
                    </td>
                </tr>
                <tr>
                    <td class="center bold text-base">{{ $school_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="center italic text-lg">{{$registration->prospectus->term->term ?? 'N/A'}} / {{$registration->school_year ?? 'N/A'}}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td class="text-primary bold truncate-wider text-base center uppercase">officialy enrolled</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>University Registrar: {{$registration->registrar->person->shortFullName ?? 'N/A'}}</td>
                </tr>
                <tr>
                    <td>Assessed by: {{$registration->assessment->approver->person->shortFullName ?? 'N/A'}}</td>
                </tr>
            </table>
        </div>
    </div>

    <footer>
        <p>Date Printed: {{ Carbon\Carbon::parse(now())->format('F j, Y') }} | Visit us: {{ env('APP_URL', 'university-ph.herokuapp.com') ?? 'N/A' }}</p>
    </footer>
</body>
</html>
